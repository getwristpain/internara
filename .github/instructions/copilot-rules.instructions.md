---
applyTo: "**"
---

# Copilot Chat Rules

This document establishes the standards for code generation, refactoring, and testing within this project.

## Professional Code Rules

### Code Quality and Communication

- Professionalism must be upheld in every aspect of code and communication.
- Code must prioritize **security**, **cleanliness**, and **maintainability**.
- All codebase elements—including **variable names**, **class names**, **method names**, and **PHPDoc documentation**—must be written in **English**.
- All **user-facing messages**, **notifications**, **labels**, and **UI texts** must be written in **Bahasa Indonesia**, except for **exception messages**.

### Testing Standards

- All **test scripts** must be written entirely in **English**.
- All tests must use **PestPHP**, utilizing `describe()` and `test()` structure appropriately.

### Property Organization

- Class properties must be **grouped and ordered** by **priority and logical grouping** (e.g., dependencies, configuration, state).
- Each group must be preceded by a **block comment** with:
  - A **title**: a short, descriptive phrase naming the section.
  - A **description**: a brief explanation of the purpose or content of that section.

### Method Organization

- All methods must be **grouped and ordered** by **priority and logic**, following this order:

  1. Static factory and utility methods
  2. Instance mutators
  3. Instance accessors
  4. Core actions (main public API)
  5. Helper methods (protected/private, internal use only)
  6. Serialization methods

- All method arguments must be ordered by **priority and logic**:
  - Required arguments first
  - Optional arguments second
  - Variadic arguments last

### Syntax and Style

- All **methods and properties** must use **strict visibility** (`public`, `protected`, `private`).
- Code must be **concise, clear, and self-descriptive**.
- Always write code as **short as possible** **without sacrificing clarity**.
- Follow the **DRY** (Don't Repeat Yourself) and **CLEAN Code** principles consistently.
- Code must comply with **professional standards** and widely-accepted **industry conventions**.

### Documentation and Output

- Every response or deliverable must include a **keypoints summary**.
