# Online Examination System with Automatic Essay Scoring

A Laravel-based web application designed to manage online examinations with role-based access control and automatic essay scoring using text similarity techniques.

---

## Project Status

This project is currently under active development as part of a Computer Science final project. 
Core features are implemented, and further improvements including deployment and optimization are planned.

---

## Environment

- PHP 8.3
- Laravel 11
- MySQL 8
- Redis 7
- Node.js v20
- Tailwind 3
- Livewire 3
- Alpine.JS

## Core Features

- Role-based authentication (Admin, Teacher, Student)
- Exam creation and management
- Student, Classroom, and Teacher management
- Exam taker controll
- Separated Services for correction
- Automated Essay Scoring using embedding and vector calculation

---

## Automatic Essay Scoring

Correction Service

1. Batching essay ref asnwer from teacher and student base on question. This optimize maximum token usage per input while maintain low count of request per minute.
2. Text embedding generation via OpenAI API
3. Cosine similarity calculation between student answer and reference answer
4. Score normalization based on similarity result

This approach enables automated evaluation of subjective responses.

---
