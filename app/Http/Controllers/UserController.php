<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function me()
    {
        return redirect()->route('users.show', user()->name);
    }

    public function show($nameOrId)
    {
        $user = User::where('name', $nameOrId)->first() ?? User::findOrFail($nameOrId);
        abort_if($user->deleted_at && (user() && !user()->can('bypass users guard')), 410);

        $user
            ->append(['discussions_count', 'replies_count'])
            ->makeVisible(['shown_role', 'last_activity', 'deleted_at'])
            ->makeHidden(['bans', 'achievements']);

        $bans = $user->bans->transform(function ($ban) {
            return $ban->only(['created_at', 'expired_at', 'comment']);
        });

        $achievements = $user->achievements->transform(function ($achievement) {
            return array_merge(
                $achievement
                    ->append(['image_url'])
                    ->only(['name', 'description', 'image_url']),
                ['unlocked_at' => $achievement->pivot->unlocked_at]
            );
        });

        if ($user->created_at->isToday()) {
            $seniority = 'aujourd\'hui';
        } elseif ($user->created_at->isLastDay()) {
            $seniority = 'hier';
        } else {
            $diff_in_days = $user->created_at->startOfDay()->diffInWeekDays(now()->startOfDay());
            $seniority = $diff_in_days . ' ' . str_plural('jour', $diff_in_days);
        }

        return Inertia::render('Users/Show', [
            'user'               => $user,
            'bans'               => $bans,
            'achievements'       => $achievements,
            'seniority'          => $seniority,
            'google_2fa_enabled' => $user->getSetting('google_2fa.enabled', false),
        ]);
    }

    public function edit($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && !user()->can('bypass users guard')) {
            return abort(403);
        }

        $achievements = user()->can('update achievements') ? Achievement::pluck('name', 'id') : [];
        $roles = user()->can('update roles') ? Role::pluck('name', 'id') : [];

        return view('user.edit', compact('user', 'achievements', 'roles'));
    }

    public function delete($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if (user()->cannot('delete users')) {
            activity()
                ->performedOn($user)
                ->withProperties(['level' => 'warning'])
                ->log('Tentative de suppression d\'utilisateur refusée (GET)');

            return abort(403);
        }

        return view('user.delete', compact('user'));
    }

    public function destroy($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if (user()->cannot('delete users')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        $user->deleted_at = now();
        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy(user())
            ->withProperties([
                'level'    => 'error',
                'method'   => __METHOD__,
                'elevated' => true,
            ])
            ->log('UserSoftDeleted');

        return redirect()->route('home');
    }
}
