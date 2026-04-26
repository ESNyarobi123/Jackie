<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public string $role = 'student';
    public string $status = 'active';
    public string $password = '';

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role?->value ?? (string) $user->role;
        $this->status = $user->status?->value ?? (string) $user->status;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->user->id)],
            'phone' => ['nullable', 'string', 'max:50', Rule::unique(User::class, 'phone')->ignore($this->user->id)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if ($validated['password'] !== '') {
            $payload['password'] = Hash::make($validated['password']);
        }

        $this->user->update($payload);

        $this->redirectRoute('admin.users.show', $this->user->fresh(), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
