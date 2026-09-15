{{-- Full-page billing layout: Filament 5's simple layout structure, without the panel sidebar. --}}
<x-filament-panels::layout.base :livewire="$livewire">
    <div class="fi-simple-layout">
        @if (($hasTopbar ?? true) && filament()->auth()->check())
            <div class="fi-simple-layout-header">
                @if (filament()->hasDatabaseNotifications())
                    @livewire(filament()->getDatabaseNotificationsLivewireComponent(), [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                        'position' => \Filament\Enums\DatabaseNotificationsPosition::Topbar,
                    ])
                @endif

                @if (filament()->hasUserMenu())
                    @livewire(\Filament\Livewire\SimpleUserMenu::class)
                @endif
            </div>
        @endif

        <main style="width: 100%">
            {{ $slot }}
        </main>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $livewire->getRenderHookScopes()) }}
    </div>
</x-filament-panels::layout.base>
