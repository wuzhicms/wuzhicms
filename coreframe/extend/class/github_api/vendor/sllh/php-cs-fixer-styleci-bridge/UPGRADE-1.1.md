# Upgrade from 1.0 to 1.1

## ConfigBridge::getLevel deprecated

Because StyleCI does not follow PHP-CS-Fixer levels, this method is deprecated.

Use directly `ConfigBridge::getFixers()` to get the whole set based on StyleCI preset and manual configuration.
