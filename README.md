## Fork note
This is a fork of https://github.com/third-bridge/behatch-contexts, to add support of symfony 7

Fixed conflicts with:
  *  `symfony/property-access: "^5.3|^6.0|^7.0"`
  *  `symfony/http-foundation: "^5.3|^6.0|^7.0"`
  *  `symfony/property-access: "^5.3|^6.0|^7.0"`

We're forking here for two reasons: first, Rkeet's fork could disappear at any point as it seemingly is for his own use. Second, we needed to tag 4.1 as master (but not 4.0) contained the fixes for correctly working with `symfony/property-access`.

Behatch contexts
================

[![Build status](https://travis-ci.org/Behatch/contexts.svg?branch=master)](https://travis-ci.org/Behatch/contexts)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Behatch/contexts/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Behatch/contexts/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Behatch/contexts/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Behatch/contexts/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ed08ea06-93c2-4b90-b65b-4364302b5108/mini.png)](https://insight.sensiolabs.com/projects/ed08ea06-93c2-4b90-b65b-4364302b5108)

Behatch contexts provide most common Behat tests.

Installation
------------

This extension requires:

* Behat 3+
* Mink
* Mink extension

### Project dependency

1. [Install Composer](https://getcomposer.org/download/)
2. Require the package with Composer:

```
$ composer require --dev behatch/contexts
```

3. Activate extension by specifying its class in your `behat.yml`:

```yaml
# behat.yml
default:
    # ...
    extensions:
        Behatch\Extension: ~
```

### Project bootstraping

1. Download the Behatch skeleton with composer:

```
$ php composer.phar create-project behatch/skeleton
```

Browser, json, table and rest step need a mink configuration, see [Mink
extension](https://github.com/Behat/MinkExtension) for more information.

Usage
-----

In `behat.yml`, enable desired contexts:

```yaml
default:
    suites:
        default:
            contexts:
                - behatch:context:browser
                - behatch:context:debug
                - behatch:context:system
                - behatch:context:json
                - behatch:context:table
                - behatch:context:rest
                - behatch:context:xml
```

### Examples

This project is self-tested, you can explore the [features
directory](./tests/features) to find some examples.

Configuration
-------------

* `browser` - more browser related steps (like mink)
    * `timeout` - default timeout
* `debug` - helper steps for debugging
    * `screenshotDir` - the directory where store screenshots
* `system` - shell related steps
    * `root` - the root directory of the filesystem
* `json` - JSON related steps
    * `evaluationMode` - javascript "foo.bar" or php "foo->bar"
* `table` - play with HTML the tables
* `rest` - send GET, POST, ... requests and test the HTTP headers
* `xml` - XML related steps

### Configuration Example

For example, if you want to change default directory to screenshots - you can do it this way:

```yaml
default:
    suites:
        default:
            contexts:
                - behatch:context:debug:
                    screenshotDir: "var"
```

Translation
-----------

[![See more information on Transifex.com](https://www.transifex.com/projects/p/behatch-contexts/resource/enxliff/chart/image_png)](https://www.transifex.com/projects/p/behatch-contexts/)
