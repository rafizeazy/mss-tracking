<div>
    <div class="flex flex-col gap-6 p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <flux:heading size="xl">{{ __('User Management') }}</flux:heading>
                <flux:subheading>{{ __('Manage user accounts and assign roles') }}</flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" wire:click="$set('showCreateModal', true)">
                {{ __('Add User') }}
            </flux:button>
        </div>

        <div class="max-w-sm">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Search users...') }}" />
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Email') }}</flux:table.column>
                <flux:table.column>{{ __('Role') }}</flux:table.column>
                <flux:table.column>{{ __('Created') }}</flux:table.column>
                <flux:table.column class="text-right">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm" :name="$user->name" :initials="$user->initials()" />
                                <span class="font-medium">{{ $user->name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" :variant="$user->role === \App\Enums\Role::SuperAdmin ? 'solid' : 'outline'">
                                {{ $user->role->label() }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $user->created_at->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button size="sm" variant="ghost" icon="pencil" wire:click="editUser({{ $user->id }})" />
                                @if ($user->id !== auth()->id())
                                    <flux:button size="sm" variant="ghost" icon="trash" wire:click="confirmDelete({{ $user->id }})" />
                                @endif
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center">
                            <flux:text>{{ __('No users found.') }}</flux:text>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <div>
            {{ $this->users->links() }}
        </div>
    </div>

    <flux:modal wire:model="showCreateModal" name="create-user" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Add New User') }}</flux:heading>
                <flux:subheading>{{ __('Create a new user account with a role') }}</flux:subheading>
            </div>

            <form wire:submit="createUser" class="space-y-4">
                <flux:input wire:model="name" :label="__('Full name')" type="text" required placeholder="Jane Smith" />
                <flux:input wire:model="email" :label="__('Email')" type="email" required placeholder="user@company.com" />
                <flux:select wire:model="role" :label="__('Role')" required>
                    <flux:select.option value="">{{ __('Select a role') }}</flux:select.option>
                    @foreach ($this->roles as $role)
                        <flux:select.option :value="$role->value">{{ $role->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="password" :label="__('Password')" type="password" required />
                <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required />

                <div class="flex justify-end gap-3 pt-2">
                    <flux:button variant="ghost" wire:click="$set('showCreateModal', false)">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" type="submit">{{ __('Create User') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal wire:model="showEditModal" name="edit-user" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit User') }}</flux:heading>
                <flux:subheading>{{ __('Update user details and role') }}</flux:subheading>
            </div>

            <form wire:submit="updateUser" class="space-y-4">
                <flux:input wire:model="name" :label="__('Full name')" type="text" required />
                <flux:input wire:model="email" :label="__('Email')" type="email" required />
                <flux:select wire:model="role" :label="__('Role')" required>
                    @foreach ($this->roles as $role)
                        <flux:select.option :value="$role->value">{{ $role->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="password" :label="__('New password')" type="password" :placeholder="__('Leave blank to keep current')" />
                <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" />

                <div class="flex justify-end gap-3 pt-2">
                    <flux:button variant="ghost" wire:click="$set('showEditModal', false)">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" type="submit">{{ __('Update User') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal wire:model="showDeleteModal" name="delete-user" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete User') }}</flux:heading>
                <flux:subheading>{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}</flux:subheading>
            </div>

            @error('delete')
                <flux:callout variant="danger">{{ $message }}</flux:callout>
            @enderror

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$set('showDeleteModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteUser">{{ __('Delete User') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
