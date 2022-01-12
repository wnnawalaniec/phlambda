# Bug reporting
If you find bug please use [issues](https://github.com/wnnawalaniec/phlambda/issues) for reporting. Issue should have `bug` label and description with some example code.
Also add information about version.

# Suggestions and Questions
If you have suggestion or question please use [discussion page](https://github.com/wnnawalaniec/phlambda/discussions).

- for quesions use [:pray: Q&A category](https://github.com/wnnawalaniec/phlambda/discussions/categories/q-a)
- for suggestions use [:bulb: Ideas category](https://github.com/wnnawalaniec/phlambda/discussions/categories/ideas)

# Developing guide
If you want to help, you must follow points:
- all functions must be tested
 - all functions must be automatically curring
 - all functions must be implemented in `Wrapper` (it's assured by tests)
   - if function shouldn't be implemented e.g. it's predicate or some math operation attribute `ShouldNotBeImplementedInWrapper` must be added
 - all function must be documented
   - because `...$v` is used for curring, `@param` should be used to document order and type of params
   - type declarations (both return and arguments) must be used
   - similar functions should be linked with `@see`
   - at least one example must be given
     - examples should be inside `<blockquote><pre>` tags
 - there must be constant with a function name (with whole namespace) like e.g. `const map = 'Wojciech\Phlambda\map'` (it's assured by tests)
 - if function name is PHP reserved key-word it must be prefixed with `_`
