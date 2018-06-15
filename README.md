# PermCheck



[![CircleCI branch](https://img.shields.io/circleci/project/github/eXistenZNL/PermCheck/master.svg?style=flat-square)](https://circleci.com/gh/eXistenZNL/workflows/PermCheck/tree/master) [![Scrutinizer branch](https://img.shields.io/scrutinizer/coverage/g/eXistenZNL/PermCheck/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/eXistenZNL/PermCheck/) [![Scrutinizer](https://img.shields.io/scrutinizer/g/eXistenZNL/PermCheck.svg?style=flat-square)](https://scrutinizer-ci.com/g/eXistenZNL/PermCheck/) [![Packagist](https://img.shields.io/packagist/v/existenznl/permcheck.svg?style=flat-square)](https://packagist.org/packages/existenznl/permcheck)  [![Packagist](https://img.shields.io/packagist/dm/existenznl/permcheck.svg?style=flat-square)](https://packagist.org/packages/existenznl/permcheck/stats) [![Packagist](https://img.shields.io/packagist/l/existenznl/permcheck.svg?style=flat-square)](https://github.com/eXistenZNL/PermCheck/blob/master/LICENSE)

## About

PermCheck is a little tool that checks if the files in a project have the executable bit set properly.
It's available for PHP versions 5.6 and up (Version 1.0 goes back to PHP 5.3), and is very light on dependencies, so you should be able to add it to nearly any project.

PermCheck aims to prevent inconsistent executable bits and thus random executable files in a project, which makes a project more consistent and more secure.

## Installation

PermCheck can be added as a composer package by running:

    composer require --dev existenznl/permcheck

## Configuration

PermCheck uses a XML configuration file which contains the sections directories and executables.

The directories section should contain all project directories that are to be checked, and the executables section should contain all files that are supposed to be executable. All files that are found but are not in the executables section, are considered to be expected non executable.

An example:

```xml
<permcheck>
    <excludes>
        <dir>.git</dir>
        <dir>vendor/</dir>
        <file>dontcare.sh</file>
    </excludes>
    <executables>
        <file>cli/console</file>
    </executables>
</permcheck>
```

In the example configuration above, everything but the dirs .git and vendor and the file dontcare.sh is validated, and only the file cli/console must be executable.

If it's not, PermCheck will issue an error.

If any other files are executable, PermCheck will issue an error.

## Usage

With a configuration XML stored somewhere in your codebase, we can now start using PermCheck.

Executing permcheck is straightforward by running the command with the required / needed flags and options.

`vendor/bin/permcheck <--config|-c=...> [--directory|-d=...]`

PermCheck makes use of the Symfony 2 [Console Component](http://symfony.com/doc/current/components/console/introduction.html) so the flags and options can be specified in the various formats outlined in the SF2 Console Component documentation.

The following options and flags are available:

| Option/flag  | Shorthand | Mandatory | Description                                                                   |
| ------------ |-----------| --------- | ----------------------------------------------------------------------------- |
| --config     | -c        | Yes       | The location of the configuration XML.                                        |
| --directory  | -d        | No        | De location of the base directory, defaults to the current working directory. |

## Bugs, questions, and improvements

If you found a bug or have a question, please open an issue on the GitHub Issue tracker.
Improvements can be sent by a Pull Request against the develop branch and are greatly appreciated!

