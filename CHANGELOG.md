# CHANGELOG

All notable changes to [https://github.com/friends-of-phpspec/phpspec-code-coverage][0] package will be
documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [6.5.0] - 2025-07-16

- Fix main PHPSpec and PHP 8.4 compatibility: Wrap service container arrays in objects [#64](https://github.com/friends-of-phpspec/phpspec-code-coverage/pull/64)
- Update GitHub workflows action versions [#65](https://github.com/friends-of-phpspec/phpspec-code-coverage/pull/65)

## [6.4.1] - 2024-08-12

- Fix issue with the path exclude logic within the coverage listener [#62](https://github.com/friends-of-phpspec/phpspec-code-coverage/pull/62)

## [6.4.0] - 2024-07-16

- Support PHP 8.3
- Compatibility with `phpunit/php-code-coverage` v11

## [6.3.0] - 2023-02-22

- Support PHP 8.2
- Compatibility with `phpunit/php-code-coverage` v10
- Fix version constraint with `phpunit/php-code-coverage`, we aren't compatible
  with version under v9.2…
- Fix CI matrix to test composer dependencies on lowest possible version and
  highest possible version to ensure valid constraints…

## [6.2.0] - 2022-01-24

- Support PHP 8.1
- Add ability to generate report in cobertura format (cf #49)
- Remove GrumPHP usage.

## [6.1.0] - 2021-03-30

- Added support for directory filtering #44

## [6.0.0] - 2020-11-28

- Support PHP 8
- Extension requires PHP7.3+ (due to `phpunit/php-code-coverage` v9 depending on it) #36
  Version 5.x will still be maintained

## [5.0.0] - 2020-11-16

- Extension requires PHP7.2+ (due to PhpSpec v7 depending on it) #37, #35

## [4.3.3] - 2020-11-16

- Support "phpunit/php-code-coverage" v8 (#27)
- Switch to GitHub actions (#25)

## [4.3.2] - 2019-11-12

- Allow compatibility with PHPSpec v6

## [4.3.1] - 2019-10-01

- Update root namespace to `FriendsOfPhpSpec` but maintain a class alias to the
  old one `LeanPHP`. The `LeanPHP` root namespace is now deprecated and will be
  removed in v5.

## [4.3.0] - 2019-10-01

**Note!** This version mark the new home of the project. It was forked from
`leanphp/phpspec-code-coverage` project and rebranded as `friends-of-phpspec/phpspec-code-coverage`.
Find details here : https://github.com/friends-of-phpspec/phpspec-code-coverage

- PHPSpec 5 support

## [4.2.2] - 2018-03-22

- Bugfix: loosen up `phpunit/php-code-coverage` from `^6.0` to `^5.0||^6.0`
- PHP 7.1 specific code improvements

## [4.2.1] - 2018-03-21

- Integrate fixes from 4.1.2 (`--no-coverage` option bugfix)
- Cleanup development dependencies
- Minor code improvements

## [4.2.0] - 2018-03-19

- Updated `phpunit/php-code-coverage` dependency from `~5.0` to `~6.0`.
- Updated PHP requirement from `^7.0` to `^7.1`
- Updated `phpspec/phpspec` dependency from `~4.0` to `^4.2`

## [4.1.2] - 2018-03-21

- Fix `--no-coverage` option introducing errors when running non `run` commands.
- `--no-coverage` option is now available to all phpspec commands (not only
  `run`). (#30)

## [4.1.1] - 2018-03-19

- Added `--no-coverage` option which can skip code coverage generation during
  PhpSpec test run.

## [4.1.0] - 2018-03-17

- `phpunit/php-code-coverage` dependency version requirement has been updated
  from `~4.0|~5.0` to `~5.0` as we do not support version `4.0` anymore.
- Updated README with information regarding `memory_limit` when generating code
  coverage reports.
- PHP 7.2 has been added to travis test matrix

## [4.0.0] - 2017-10-17 - PhpSpec v4 / PHP 7+ release

This release adds support for PhpSpec v4. As a result of this, PHP requirement
has also been updated to PHP 7+.

- Added PhpSpec4 support #10
- Extension requires PHP7+ (due to PhpSpec v4 depending on it) #10

## [3.1.1] - 2017-10-17 - Maintenance release for PhpSpec v3

- PHPSpec version is now included when generating XML report #12
- Added example configuration options for generating XML report #12
- Minor cleanup in export-ignores. Should result in cleaner dist install #8

## [3.1.0] - 2017-02-21 (backported master branch on 2017-02-21)

**Note!** This is last backported release which pulls all the changes from the
`master` branch of `henrikbjorn/phpspec-code-coverage` project and releases it as
`3.1.0`.

- Add support for `php-code-coverage` v5.

## [3.0.1] - 2017-02-14 (backported v3.0.1, original release on 2016-08-02)

- Require PhpSpec3
- Require PHP 5.6+ / PHP 7.0+

## [2.1.0] - 2017-02-12 (backported v2.1.0, original release on 2016-05-05)

**Note!** v2.1.0 is final release to support PhpSpec2.

- Added PHP 7 support
- Added `phpdbg` extension support (alternative to `xdebug`)
- Updated `blacklist` to include `test` directory by default
- Updated `text` output to use coloring by default.

## [1.0.1] - 2017-02-11 (backported v1.0.1, original release on 2014-12-11)

**Note!** This version is a direct backport of `1.0.1` of
[henrikbjorn/phpspec-code-coverage][1] package with updated namespaces to work
as [leanphp/phpspec-code-coverage][0].

- PHP `>=5.3`
- PhpSpec `~2.0`
- Xdebug `>=2.1.4`
- Supports Code Coverage generation in `html`, `clover`, `php` and `txt`
  formats.
- Supports per-format `output` directory configuration (e.g.
  `clover:clover.xml`)
- Supports configuring inclusion of uncovered files in code coverage reports.
- Supports configuring lower upper and higher lower bounds for code coverage
  reports.
- Supports configuring a whiltelist of directories to be included in code
  coverage report (`whilelist` option).
- Supports configuring a whiltelist of files to be included in code coverage
  reports (`whitelist_files` option).
- Support configuring a blacklist of directories to be excluded from code
  coverage reports (`blacklist` option).
- Support configuring a blacklist of files to be excluded from code coverage
  reports (`blacklist_files` option).

[4.3.2]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.3.2
[4.3.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.3.1
[4.3.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.3.0
[4.2.2]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.2.2
[4.2.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.2.1
[4.2.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.2.0
[4.1.2]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.1.2
[4.1.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.1.1
[4.1.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.1.0
[4.0.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v4.0.0
[3.1.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v3.1.1
[3.1.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v3.1.0
[3.0.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v3.0.1
[2.1.0]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v2.1.0
[1.0.1]: https://github.com/friends-of-phpspec/phpspec-code-coverage/releases/tag/v1.0.1

[0]: https://github.com/friends-of-phpspec/phpspec-code-coverage
[1]: https://github.com/henrikbjorn/PhpSpecCodeCoverageExtension
