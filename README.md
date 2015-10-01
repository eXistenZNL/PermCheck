## About

PermCheck is a little tool that checks if the files in a project have the executable bit set properly.

This prevent inconsistent executable bits and thus random executable files in a project, which makes a project more consistent and more secure.

## Installation

PermCheck can be added as a composer package by adding it to your composer.json:

    {
        "require-dev": {
            "enrise/permcheck": "1.0.*"
        }
    }

## Configuration

PermCheck uses a XML configuration file which contains the sections directories and executables.

The directories section should contain all project directories that are to be checked, and the executables section should contain all files that are supposed to be executable. All files that are found but are not in the executables section, are considered to be expected non executable.

An example:

    <permcheck>
        <directories>
            <dir>app/</dir>
            <dir>src/</dir>
            <dir>cli/</dir>
        </directories>
        <executables>
            <file>cli/console</file>
        </executables>
    </permcheck>

In the example configuration above, the dirs app, src, and cli are validated, and only the file cli/console must be executable.

If it's not, PermCheck will issue an error.

If any other files are executable, PermCheck will issue an error.

## Usage

With a configuration XML stored somewhere in your codebase, we can now start using PermCheck.

Executing permcheck is straightforward by running the command with the required / needed flags and options.

`vendor/bin/permcheck <--config|-c=...> [--directory|-d=...] [--exitstatus] [--report|-r=...] [--verbose]`

PermCheck makes use of the Symfony 2 [Console Component](http://symfony.com/doc/current/components/console/introduction.html) so the flags and options can be specified in the various formats outlined in the SF2 Console Component documentation.

The following options and flags are available:

| Option/flag  | Shorthand | Mandatory | Description                                                                   |
| ------------ |-----------| --------- | ----------------------------------------------------------------------------- |
| --config     | -c        | Yes       | The location of the configuration XML.                                        |
| --directory  | -d        | No        | De location of the base directory, defaults to the current working directory. |
| --exitstatus | -e        | No        | If specified, PermCheck will exit with status 1 if the check fails.           |
| --report     | -r        | No        | If specified, a status XML will be written to this location.                  |
| --verbose    | -v        | No        | If specified, the errors will be printed to the console.                      |

## Report format


