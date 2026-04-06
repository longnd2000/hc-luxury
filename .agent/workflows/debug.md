---
description: How to debug PHP code using write_log().
---

# Debug Workflow

## Steps

1. **Add log call**: Use `write_log()` (defined in `inc/helpers.php`):
   ```php
   write_log($variable);                    // Basic log
   write_log($variable, 'My Label');         // With label
   write_log($array_or_object, 'Data');      // Arrays/objects auto-formatted
   ```

2. **Trigger the code**: Visit the page or perform the action that executes the logged code.

3. **Read the log file**:
   ```
   Log location: wp-content/debug.log
   Format: [2026-04-06 10:30:00] : My Label - Log: {value}
   ```

4. **Analyze**: Check the logged output for unexpected values.

5. **Cleanup (MANDATORY)**: Remove **all** `write_log()` calls after debugging is complete. Debug logs must never remain in production code.

## Rules
- **NEVER** use `var_dump()`, `print_r()`, `error_log()`, or `echo` for debug output.
- Always use `write_log()` as the single standard.
