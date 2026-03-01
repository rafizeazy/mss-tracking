<div>
    <div class="py-6">
        {{-- Page Title --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('User Management') }}</h4>
                <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Manage user accounts and assign roles') }}</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-[#8a969c]">
                <i class="ti ti-home text-base"></i>
                <span>/</span>
                <span>{{ __('Administration') }}</span>
                <span>/</span>
                <span class="font-medium text-[#313a46] dark:text-white">{{ __('Users') }}</span>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="boron-card">
            <div class="boron-card-header">
                <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('All Users') }}</h5>
                <button wire:click="$set('showCreateModal', true)"
                    class="btn-boron btn-boron-primary inline-flex items-center gap-2 !px-4 !py-2 text-sm"
                >
                    <i class="ti ti-plus text-base"></i>
                    {{ __('Add User') }}
                </button>
            </div>
            <div class="boron-card-body">
                {{-- Search --}}
                <div class="mb-5 max-w-sm">
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            placeholder="{{ __('Search users...') }}"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:border-[#669776] focus:outline-none focus:ring-2 focus:ring-[#669776]/20 dark:border-[#37394d] dark:focus:border-[#669776]"
                        >
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="boron-table w-full">
                        <thead>
                            <tr>
                                <th class="text-left">{{ __('Name') }}</th>
                                <th class="text-left">{{ __('Email') }}</th>
                                <th class="text-left">{{ __('Role') }}</th>
                                <th class="text-left">{{ __('Created') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->users as $user)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <span class="flex size-8 items-center justify-center rounded-full bg-[#669776]/15 text-xs font-bold text-[#669776]">
                                                {{ $user->initials() }}
                                            </span>
                                            <span class="font-medium text-[#313a46] dark:text-white">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($user->role) {
                                                \App\Enums\Role::SuperAdmin => 'badge-soft-danger',
                                                \App\Enums\Role::Noc => 'badge-soft-info',
                                                \App\Enums\Role::Finance => 'badge-soft-success',
                                                \App\Enums\Role::Marketing => 'badge-soft-warning',
                                                default => 'badge-soft-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $user->role->label() }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="editUser({{ $user->id }})"
                                                class="boron-topbar-btn !size-8 !rounded-[0.3rem]" title="{{ __('Edit') }}"
                                            >
                                                <i class="ti ti-pencil text-sm"></i>
                                            </button>
                                            @if ($user->id !== auth()->id())
                                                <button wire:click="confirmDelete({{ $user->id }})"
                                                    class="boron-topbar-btn !size-8 !rounded-[0.3rem] text-[#ed6060] hover:!bg-[#ed6060]/10" title="{{ __('Delete') }}"
                                                >
                                                    <i class="ti ti-trash text-sm"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-[#8a969c]">
                                        <div class="py-8">
                                            <i class="ti ti-users-minus mb-2 text-3xl text-[#a1a9b1]"></i>
                                            <p>{{ __('No users found.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $this->users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
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

    {{-- Edit Modal --}}
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

    {{-- Delete Modal --}}
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
