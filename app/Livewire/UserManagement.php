<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('User Management')]
#[Layout('layouts.app')]
class UserManagement extends Component
{
    use WithPagination;

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = '';

    public ?int $editingUserId = null;

    public ?int $deletingUserId = null;

    public string $search = '';

    public function createUser(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', new Enum(Role::class)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => now(),
        ]);

        $this->resetForm();
        $this->showCreateModal = false;
        $this->dispatch('user-created');
    }

    public function editUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role->value;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showEditModal = true;
    }

    public function updateUser(): void
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->editingUserId],
            'role' => ['required', new Enum(Role::class)],
        ];

        if (filled($this->password)) {
            $rules['password'] = ['string', 'min:8', 'confirmed'];
        }

        $validated = $this->validate($rules);

        $user = User::findOrFail($this->editingUserId);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if (filled($this->password)) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $this->resetForm();
        $this->showEditModal = false;
        $this->dispatch('user-updated');
    }

    public function confirmDelete(int $userId): void
    {
        $this->deletingUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        $user = User::findOrFail($this->deletingUserId);

        if ($user->id === auth()->id()) {
            $this->addError('delete', 'You cannot delete your own account.');

            return;
        }

        $user->delete();
        $this->showDeleteModal = false;
        $this->deletingUserId = null;
        $this->dispatch('user-deleted');
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn ($query) => $query
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function roles(): array
    {
        return Role::cases();
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'editingUserId', 'deletingUserId']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.user-management');
    }
}
