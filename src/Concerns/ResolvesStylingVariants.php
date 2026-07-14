<?php

namespace Fractas\ElementalStylings\Concerns;

trait ResolvesStylingVariants
{
    /**
     * @param array<string, string> $definitions
     * @return array<string, string>
     */
    protected function getEnabledVariantOptions(string $configName, array $definitions): array
    {
        $configured = $this->getConfiguredVariantClasses($configName);

        return array_intersect_key($definitions, $configured);
    }

    protected function getConfiguredVariantClass(string $configName, ?string $key): string
    {
        if ($key === null) {
            return '';
        }

        return $this->getConfiguredVariantClasses($configName)[$key] ?? '';
    }

    /**
     * @param array<string, string> $definitions
     */
    protected function getDefaultVariantKey(string $configName, array $definitions): ?string
    {
        return array_key_first($this->getEnabledVariantOptions($configName, $definitions));
    }

    /**
     * @return array<string, string>
     */
    private function getConfiguredVariantClasses(string $configName): array
    {
        $configured = $this->getOwner()->config()->get($configName);
        if (!is_array($configured)) {
            return [];
        }

        return array_filter(
            $configured,
            static fn (mixed $classes, mixed $key): bool => is_string($key) && is_string($classes),
            ARRAY_FILTER_USE_BOTH
        );
    }
}
