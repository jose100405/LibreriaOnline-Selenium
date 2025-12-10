# Librería Online – Pruebas Automatizadas con Selenium

Link para el repositorio: https://github.com/jose100405/LibreriaOnline-Selenium

Link de jira: https://chanisafrodriguez16.atlassian.net/jira/software/projects/LOS/boards/35/backlog

link para abrir el login en local: http://localhost/libreria/login.php

En la carpeta llamada, programacion 3 proyecto final, esta el PDF del documento final de la materia 

Credenciales de prueba: 
Usuario: admin
Contraseña: Admin123


### Cómo ejecutar las pruebas automatizadas

1. Abrir la solución `LibreriaOnline.Tests.sln` en Visual Studio.
2. Verificar que la URL base en `LoginTests.cs` es: `http://localhost/libreria/`.
3. Ir a **Test > Run All Tests** (o desde el Explorador de pruebas).
4. Revisar que las 3 pruebas de login pasan en verde.

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
