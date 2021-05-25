# 🪝 Git Hooks [![GitHub Actions (tests)](https://github.com/rugaard/git-hooks/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/rugaard/git-hooks/actions/workflows/tests.yml)

This is a Composer plugin, which installs an application, that manages and handles everything related to `git` hooks in your project.

## 📖 Table of contents

* [Features](#-features)
  * [Git hooks in PHP](#--git-hooks-in-php)
  * [Split scripts into separate files](#--split-scripts-into-separate-files)
  * [Auto registering](#--auto-registering)
  * [Share your Git hooks](#--share-your-git-hooks)
* [Installation](#-installation)
* [Usage](#%EF%B8%8F-usage)
  * [Custom configuration](#-custom-configuration)
    * [Register scripts](#register-scripts)
    * [Disable scripts](#disable-scripts)
    * [Script parameters](#script-parameters)
* [List registered scripts](#-list-registered-scripts)
* [Create your own Git hook](#-create-your-own-git-hook)
* [License](#-license)

## 🌟 Features

### 🐘  Git hooks in PHP

Web developers is not necessarily experts when it comes to shell scripting. With Git Hooks, this is no longer an issue. You can now write your plugins in PHP and can utilize all it's features.

### 🗂  Split scripts into separate files

If you wanted a git hook to perform serveral things, you would normally have to put it all into a single file. This increases the risk of errors, bloats the file, etc. By using this application, you can write and register each script individually. This makes it easier to read, understand and not to mention debug.

### 🪄  Auto registering

The application will automatically locate git hooks from compatible packages and automatically register and enable them. This means you don't have to configure anything. You install the package with your desired git hooks and that's it.

### 📤  Share your Git hooks

The purpose of this application is to separate and "modularize" the git hooks. Fx. you could create a package, with your most used git hooks from your projects and share it in a community or with your colleagues. 

## 📦 Installation

You install the package via [Composer](https://getcomposer.org/) by using the following command:

```shell
composer require rugaard/git-hooks
```

## ⚙️ Usage

Whenever you're performing `git` actions, the application will automatically run and execute the appropriate scripts to the triggered git hooks. There is no manual involvement required. 

However, it is possible to create a custom configuration file, where you can disable scripts and overwrite/append arguments, if the script supports it.

### 📝 Custom configuration

To create a custom configuration, you need to run the following command, in the root of your project:

```shell
./vendor/bin/git-hooks config
```

This creates a `git-hooks.config.json` file, which contains a few options: `register`, `disable` and `parameters`.

#### Register scripts

You can create and register your own project specific scripts, by adding it to the `register` array in the custom configuration file:

```json
{
  "register": [
    "Namespace\\GitHooks\\PreCommit\\ForceIssueNumberCommand"
  ],
  "disable": [],
  "parameters": {}
}
```

#### Disable scripts

You might find a git-hook collection with multiple scripts, but you are not interested in using all of them at once. Instead of skipping the entire collection or create your own collection, you can instead disable the scripts you don't want to use.

To disable a script, simply add it to `disable` array in the custom configuration file:

```json
{
  "register": [],
  "disable": [
    "Namespace\\GitHooks\\PreCommit\\ValidateMessageCommand"
  ],
  "parameters": {}
}
```

#### Script parameters

It's possible to overwrite or append arguments to specific scripts, if these scripts supports it. This gives some form of flexibility when installing a git-hook collection from a 3rd party.

An example could be, that you wanted to change the "printer" that the installed PHPUnit script uses:

```json
{
  "register": [],
  "disable": [],
  "parameters": {
    "Namespace\\GitHooks\\PrePush\\PhpTestSuiteCommand": {
      "driver": "phpunit",
      "config": "tests/phpunit.xml"
    }
  }
}
```

## 🧩 List registered scripts

To get an overview of which scripts are registered with the application, you can run the following command:

```shell
./vendor/bin/git-hooks registered
```

This command also lists the namespaces of each script, which is needed if you're [using a custom configuration file](#-custom-configuration).

## 🧑🏻‍💻 Create your own Git hook

Follow the guide in the [projects Wiki](https://github.com/rugaard/git-hooks/wiki).

## 🚓 License

This package is licensed under [MIT](https://github.com/rugaard/git-hooks/blob/main/LICENSE).
