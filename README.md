# Devskiller programming task sample - PHP with Phing

## Introduction

With [Devskiller.com](https://devskiller.com) you can assess your candidates'
programming skills as a part of your recruitment process. We have found that
programming tasks are the best way to do this and have built our tests
accordingly. The way our test works is your candidate is asked to modify the
source code of an existing project.

During the test, your candidates have the option of using our browser-based
code editor and can build the project inside the browser at any time. If they
would prefer to use an IDE they are more comfortable with, they can also
download the project code or clone the project’s Git repository and work
locally.

You can check out this short video to see the test from the [candidate's
perspective](https://goo.gl/AXXaTT).

This repo contains a sample project for PHP with Phing and below you can
find a detailed guide for creating your own programming project.

**Please make sure to read our [Getting started with programming
projects](https://goo.gl/gkQU4J) guide first**

## Technical details

Any **Phing** project may be used as a programming task. We use **PHPUnit** for
unit tests and **composer** for external dependencies.

We support following project structure for Phing projects. Please, be sure to
put your `build.xml` inside `build/` directory.

```
PROJECT_ROOT/
    app/                # PHP Source code
        ...
    build/
        build.xml       # Phing project descriptor
    tests/              # Unit tests
        ...
    composer.json       # Composer dependencies descriptor
    phpunit.xml         # PHPUnit configuration
```

Phing build will be executed with the following command:

```sh
phing -f build/build.xml
```

When configuring your project ensure that the junit test logger is enabled in
`phpunit.xml`:

```xml
    <logging>
        <log type="junit" target="build/logs/TEST-junit.xml" logIncompleteSkipped="false" title="Test Results"/>
    </logging>
```

## Automatic assessment

It is possible to automatically assess the solution posted by the candidate.
Automatic assessment is based on unit tests results and code quality
measurements.

There are two kinds of unit tests:

1. **Candidate tests** - unit tests that the candidate can see during the test
   should be used only for basic verification and to guide the candidate in
   understanding the requirements of the project. Candidate tests WILL NOT be used
   to calculate the final score.
2. **Verification tests** - unit tests that the candidate can’t see during the
   test. Files containing verification tests will be added to the project after
   the candidate finishes the test and will be executed during the verification
   phase. The results of the verification tests will be used to calculate the
   final score.

Once the solution is developed and submitted, the platform executes
verification tests and performs static code analysis.

## Devskiller project descriptor

Programming tasks can be configured with the Devskiller project descriptor file:

1. Create a `devskiller.json` file.
2. Place it in the root directory of your project.

Here is an example project descriptor:

```json
{
  "readOnlyFiles" : ["phpunit.xml", "build/build.xml"],
  "verification" : {
    "testNamePatterns" : [".*verify_pack.*"],
    "pathPatterns" : ["**tests/verify_pack**"]
  }
}
```

You can find more details about the `devskiller.json` descriptor in our
[documentation](https://goo.gl/uWXeCD).

## Automatic verification with verification tests

The solution submitted by the candidate may be verified using automated tests.
You’ll just have to define which tests should be treated as verification tests.

All files classified as verification tests will be removed from the project
prior to inviting the candidate.

To define verification tests, you need to set two configuration properties in
`devskiller.json`:

- `testNamePatterns` - an array of RegEx patterns which should match all the
  names of the verification tests.
- `pathPatterns` - an array of GLOB patterns which should match all the files
  containing verification tests. All the files that match defined patterns will
  be deleted from candidates' projects and will be added to the projects during
  the verification phase. These files will not be visible to the candidate during
  the test.

In our sample task all verifications tests are in `verify_pack` namespace. In this case
the following patterns will be sufficient:

```json
"testNamePatterns" : [".*verify_pack.*"],
"pathPatterns" : ["**tests/verify_pack**"]
```
