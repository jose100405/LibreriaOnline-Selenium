using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using OpenQA.Selenium.Support.UI;

namespace LibreriaOnline.Tests
{
    [TestClass]
    public class LoginTests
    {
        private IWebDriver _driver;
        private WebDriverWait _wait;

        // Ajusta si tu proyecto no está exactamente en /libreria/
        private const string BaseUrl = "http://localhost/libreria/";

        [TestInitialize]
        public void SetUp()
        {
            var options = new ChromeOptions();
            options.AddArgument("--start-maximized");

            _driver = new ChromeDriver(options);
            _wait = new WebDriverWait(_driver, TimeSpan.FromSeconds(5));
        }

        [TestCleanup]
        public void TearDown()
        {
            _driver.Quit();
        }

        // Método auxiliar para hacer login sin repetir código
        private void DoLogin(string user, string pass)
        {
            _driver.Navigate().GoToUrl(BaseUrl + "login.php");

            var txtUser = _driver.FindElement(By.Id("txtUsername"));
            var txtPass = _driver.FindElement(By.Id("txtPassword"));
            var btn = _driver.FindElement(By.Id("btnLogin"));

            txtUser.Clear();
            txtUser.SendKeys(user);

            txtPass.Clear();
            txtPass.SendKeys(pass);

            btn.Click();
        }

        // 🟢 Camino feliz: credenciales correctas
        [TestMethod]
        public void Login_CaminoFeliz_CredencialesValidas_RedireccionaAlIndex()
        {
            DoLogin("admin", "Admin123");  // usuario/clave que tienes en la tabla usuarios

            _wait.Until(d => d.Url.Contains("index.php"));

            Assert.IsTrue(_driver.Url.Contains("index.php"));
            Assert.IsTrue(_driver.PageSource.Contains("Bienvenido a la Librería Online"));
        }

        // 🔴 Prueba negativa: credenciales incorrectas
        [TestMethod]
        public void Login_Negativo_CredencialesInvalidas_MuestraMensajeError()
        {
            DoLogin("admin", "ClaveMala123");

            _wait.Until(d => d.Url.Contains("login.php"));

            var error = _driver.FindElement(By.Id("errorMessage"));

            Assert.IsTrue(error.Displayed);
            Assert.IsTrue(error.Text.Contains("Usuario o contraseña incorrectos"));
        }

        // 🟡 Prueba de límite: campos vacíos
        [TestMethod]
        public void Login_Limite_CamposVacios_MuestraMensajeCamposObligatorios()
        {
            _driver.Navigate().GoToUrl(BaseUrl + "login.php");

            var btn = _driver.FindElement(By.Id("btnLogin"));
            btn.Click();

            // Esperar hasta que aparezca el div de error
            _wait.Until(d =>
            {
                try
                {
                    var e = d.FindElement(By.Id("errorMessage"));
                    return e.Displayed && !string.IsNullOrWhiteSpace(e.Text);
                }
                catch (NoSuchElementException)
                {
                    return false;
                }
            });

            var error = _driver.FindElement(By.Id("errorMessage"));

            Assert.IsTrue(error.Displayed);
            StringAssert.Contains(error.Text, "Debes completar todos los campos");
        }
    }
}
