# Cortex OAuth Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v2.0.5] - 2021-01-15
- Add model replication feature

## [v2.0.4] - 2021-01-02
- Move cortex:autoload & cortex:activate commands to cortex/foundation module responsibility

## [v2.0.3] - 2021-01-01
- Move cortex:autoload & cortex:activate commands to cortex/foundation module responsibility
  - This is because :autoload & :activate commands are registered only if the module already autoloaded, so there is no way we can execute commands of unloaded modules
  - cortex/foundation module is always autoloaded, so it's the logical and reasonable place to register these :autoload & :activate module commands and control other modules from outside

## [v2.0.2] - 2020-12-31
- Rename seeders directory
- Enable StyleCI risky mode
- Add module activate, deactivate, autoload, unload artisan commands

## [v2.0.1] - 2020-12-25
- Add support for PHP v8

## [v2.0.0] - 2020-12-22
- Upgrade to Laravel v8
- Add missing composer dependency
- Merge tag 'v1.0.1' into develop

## [v1.0.1] - 2020-12-12
- Move example usage routes to README
- Fix wrong route method
- Update composer dependencies
- Fix code style & enforce consistency

## v1.0.0 - 2020-12-12
- Tag first release

[v2.0.5]: https://github.com/rinvex/cortex-oauth/compare/v2.0.4...v2.0.5
[v2.0.4]: https://github.com/rinvex/cortex-oauth/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/rinvex/cortex-oauth/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/rinvex/cortex-oauth/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/rinvex/cortex-oauth/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/rinvex/cortex-oauth/compare/v1.0.1...v2.0.0
[v1.0.1]: https://github.com/rinvex/cortex-oauth/compare/v1.0.0...v1.0.1
