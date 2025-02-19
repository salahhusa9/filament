<?php

namespace Filament\Navigation;

use Closure;

class NavigationItem
{
    protected ?string $group = null;

    protected ?Closure $isActiveWhen = null;

    protected string $icon;

    protected ?string $activeIcon = null;

    protected ?string $iconColor = null;

    protected string $label;

    protected ?string $badge = null;

    protected ?string $badgeColor = null;

    protected bool $shouldOpenUrlInNewTab = false;

    protected ?int $sort = null;

    protected string | Closure | null $url = null;

    protected bool $isHidden = false;

    protected bool $isVisible = true;

    final public function __construct(?string $label = null)
    {
        if (filled($label)) {
            $this->label($label);
        }
    }

    public static function make(?string $label = null): static
    {
        return app(static::class, ['label' => $label]);
    }

    public function badge(?string $badge, ?string $color = null): static
    {
        $this->badge = $badge;
        $this->badgeColor = $color;

        return $this;
    }

    public function group(?string $group): static
    {
        $this->group = $group;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function visible(bool | Closure $condition = true): static
    {
        $this->isVisible = value($condition);

        return $this;
    }

    public function visibleIfCan(string $ability): static
    {
        $this->visible(fn () => auth()->user()?->can($ability));

        return $this;
    }

    public function hidden(bool | Closure $condition = true): static
    {
        $this->isHidden = value($condition);

        return $this;
    }

    public function hiddenIfCan(string $ability): static
    {
        $this->hidden(fn () => auth()->user()?->can($ability));

        return $this;
    }

    public function activeIcon(string $activeIcon): static
    {
        $this->activeIcon = $activeIcon;

        return $this;
    }

    public function iconColor(?string $iconColor): static
    {
        $this->iconColor = $iconColor;

        return $this;
    }

    public function isActiveWhen(Closure $callback): static
    {
        $this->isActiveWhen = $callback;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function openUrlInNewTab(bool $condition = true): static
    {
        $this->shouldOpenUrlInNewTab = $condition;

        return $this;
    }

    public function sort(?int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function url(string | Closure | null $url, bool $shouldOpenInNewTab = false): static
    {
        $this->shouldOpenUrlInNewTab = $shouldOpenInNewTab;
        $this->url = $url;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function getBadgeColor(): ?string
    {
        return $this->badgeColor;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function isVisible(): bool
    {
        return ! $this->isHidden();
    }

    public function isHidden(): bool
    {
        if ($this->isHidden) {
            return true;
        }

        return ! $this->isVisible;
    }

    public function getActiveIcon(): ?string
    {
        return $this->activeIcon;
    }

    public function getIconColor(): ?string
    {
        return $this->iconColor;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSort(): int
    {
        return $this->sort ?? -1;
    }

    public function getUrl(): ?string
    {
        return value($this->url);
    }

    public function isActive(): bool
    {
        $callback = $this->isActiveWhen;

        if ($callback === null) {
            return false;
        }

        return app()->call($callback);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->shouldOpenUrlInNewTab;
    }
}
