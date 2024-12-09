import React, { useState, Fragment } from "react";
import { Helmet } from "react-helmet-async";
import api from "../../../services/api";
import AuthService from "../../../services/AuthService";
import { FaGoogle } from "react-icons/fa";
import GoogleLoginButton from "../../../components/Buttons/button-google";
function LoginScreen() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [errors, setErrors] = useState([]);
  const [success, setSuccess] = useState("");

  const handleLoginGoogle = (e) => {
    e.preventDefault();
    AuthService.loginWithGoogle();
  }
  

  const handleSubmit = async (e) => {
    e.preventDefault();

    setErrors([]);

    if (!email || !password) {
      setErrors(["Por favor, preencha todos os campos"]);
      return;
    }

    try {
      // Fazer a requisição de login utilizando a instância configurada do Axios
      const response = await api.post('/login', { email, password });

      console.log(response.data); // Log para depuração

      const token = response.data;

      if (token) {
        localStorage.setItem('authToken', token); // Armazenar o token de autenticação corretamente
        setSuccess("Login realizado com sucesso!");
        setEmail("");
        setPassword("");
        // Usar window.location.href para redirecionar
        window.location.href = '/home';
      } else {
        setErrors(["Erro ao obter o token de autenticação."]);
      }
    } catch (error) {
      console.error("Erro ao realizar login:", error.response);
      const errorMessage = error.response?.data?.message || "Erro ao realizar login.";
      setErrors([errorMessage]);
    }
  };

  return (
    <Fragment>
      <Helmet>
        <title>Acesso - SimplificaMed</title>
      </Helmet>

      <div className="container pt-5 col-md-6 offset-md-3 pb-5">
        <header className="text-center mb-4">
          <h1>Página de Login</h1>
        </header>

        <nav className="d-flex justify-content-end mb-4">
          <a href="/register" className="btn btn-link"></a>
        </nav>

        {errors.length > 0 && (
          <div className="alert alert-danger">
            <ul className="mb-0">
              {errors.map((error, index) => (
                <li key={index}>{error}</li>
              ))}
            </ul>
          </div>
        )}

        {success && <div className="alert alert-success">{success}</div>}

        <main className="card p-4 shadow-sm">
          <form onSubmit={handleSubmit}>
            <h2 className="mb-4">Entrar</h2>
            <div className="mb-3">
              <label htmlFor="email" className="form-label">Email</label>
              <input
                type="email"
                name="email"
                id="email"
                className="form-control"
                placeholder="Insira o e-mail"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="mb-3">
              <label htmlFor="password" className="form-label">Senha</label>
              <input
                type="password"
                name="password"
                id="password"
                className="form-control"
                placeholder="Insira a senha"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div className="w-50 mx-auto">
              <button type="submit" className="btn btn-primary w-100 my-1">Entrar</button>
              <GoogleLoginButton handleLoginGoogle={handleLoginGoogle}/>
            </div>
          </form>
          <div className="mt-3 text-center">
            <a href="/register" className="link-primary">
              Ainda não tem uma conta? Faça seu cadastro!
            </a>
          </div>
        </main>
      </div>
    </Fragment>
  );
}

export default LoginScreen;
