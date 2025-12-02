# Librería Online – Pruebas Automatizadas con Selenium

Este repositorio contiene:

- La aplicación web **Librería Online** hecha en **PHP + MySQL + PDO**.
- El proyecto de pruebas automatizadas en **C# + MSTest + Selenium WebDriver**.
- Las evidencias (capturas de pantalla) de la ejecución de las pruebas.

Es el proyecto final de la asignatura **Programación Web / Automatización de Pruebas**.

---

## 🧱 Estructura del repositorio

```text
LibreriaOnline-Selenium/
├─ libreria/                # Proyecto PHP (Librería Online)
│  ├─ index.php
│  ├─ login.php
│  ├─ login_procesar.php
│  ├─ config.php
│  └─ (resto de archivos .php, css, img, etc.)
│
├─ LibreriaOnline.Tests/    # Proyecto de pruebas automatizadas (C# + MSTest)
│  ├─ LoginTests.cs
│  ├─ MSTestSettings.cs
│  └─ (archivos de configuración del proyecto .NET)
│
├─ Evidencias/              # Capturas de pantalla generadas por las pruebas
│  └─ *.png
│
└─ docs/                    # Documentos de apoyo (opcional: informe, casos de prueba, etc.)
