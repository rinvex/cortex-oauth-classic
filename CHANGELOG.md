# Cortex OAuth Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v2.0.13] - 2021-05-24
- Drop common blade views in favor for accessarea specific views
- Remove duplicate button options, it's already merged from default config

## [v2.0.12] - 2021-05-07
- Upgrade to GitHub-native Dependabot
- Rename migrations to always run after rinvex core packages

## [v2.0.11] - 2021-03-15
- fix create member, admin and manager
- Remove oauth 'authorizations.' route name prefix

## [v2.0.10] - 2021-03-02
- Autoload artisan commands

## [v2.0.9] - 2021-03-02
- Fix user parsed scopes for API authorization request
- Change middleware order

## [v2.0.8] - 2021-02-28
- Whitelist ussueToken method from middleware
- Enforce consistency
- Append `SetAuthDefaults` middleware on `api` middleware group
- Simplify and utilize request()->user() and request()->guard()
- Use overridden `FormRequest` instead of native class
- Rename `id` column to `identifier` for refresh token, access token, and auth codes, and drop primary index, just make unique
- Add timestamps for refresh token, access token, and auth codes
- Add missing menu permissions
- Fix parent controller for AuthorizationController
- Fix authorized controllers to use abilities correctly
- Remove useless obscure features from models since the primary ids are hashed already (not numeric anyway)
- Register middleware
- Enforce consistency
- Refactor "scopes" and use "abilities" instead
- Refactor provider to user_type

## [v2.0.7] - 2021-02-11
- Expect hashed client ID, and resolve it
- Fix user provider features and conventions
- Simplify datatables ResourceUserScope
- Fix wrong datatables route names
- Refactor broadcasting channels
- Replace form timestamps with common blade view

## [v2.0.6] - 2021-02-07
- Replace silber/bouncer package with custom modified tmp version
- Generate encryption keys and create personal access & password clients on installation
- Skip publishing module resources unless explicitly specified, for simplicity

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

[v2.0.13]: https://github.com/rinvex/cortex-oauth/compare/v2.0.12...v2.0.13
[v2.0.12]: https://github.com/rinvex/cortex-oauth/compare/v2.0.11...v2.0.12
[v2.0.11]: https://github.com/rinvex/cortex-oauth/compare/v2.0.10...v2.0.11
[v2.0.10]: https://github.com/rinvex/cortex-oauth/compare/v2.0.9...v2.0.10
[v2.0.9]: https://github.com/rinvex/cortex-oauth/compare/v2.0.8...v2.0.9
[v2.0.8]: https://github.com/rinvex/cortex-oauth/compare/v2.0.7...v2.0.8
[v2.0.7]: https://github.com/rinvex/cortex-oauth/compare/v2.0.6...v2.0.7
[v2.0.6]: https://github.com/rinvex/cortex-oauth/compare/v2.0.5...v2.0.6
[v2.0.5]: https://github.com/rinvex/cortex-oauth/compare/v2.0.4...v2.0.5
[v2.0.4]: https://github.com/rinvex/cortex-oauth/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/rinvex/cortex-oauth/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/rinvex/cortex-oauth/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/rinvex/cortex-oauth/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/rinvex/cortex-oauth/compare/v1.0.1...v2.0.0
[v1.0.1]: https://github.com/rinvex/cortex-oauth/compare/v1.0.0...v1.0.1
