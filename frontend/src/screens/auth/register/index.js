import React, { useState, Fragment } from "react";
import { Helmet } from "react-helmet-async";
import AuthService from "../../../services/AuthService";

function RegisterScreen() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [errors, setErrors] = useState([]);
  const [success, setSuccess] = useState("");

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      // Chamada para o AuthService para registrar o usuário
      console.log(formData);
      const response = await AuthService.register(formData);
      console.log(response);
      setSuccess("Cadastro realizado com sucesso!");
      setErrors([]);

      setTimeout(() => {
        window.location.href = "/home";
      }, 2000);
    } catch (error) {
      const errorMessages = error.response?.data?.errors || [
        "Erro ao cadastrar",
      ];
      setErrors(Object.values(errorMessages).flat());
    }
  };

  return (
    <Fragment>
      <Helmet>
        <title>Cadastro - SimplificaMed</title>
      </Helmet>

      <div className="container pt-5 col-md-6 offset-md-3 pb-5">
        <header className="text-center mb-4">
          <h1>Página de Cadastro</h1>
        </header>

        {/* Exibir mensagens de erro */}
        {errors.length > 0 && (
          <div className="alert alert-danger">
            <ul className="mb-0">
              {errors.map((error, index) => (
                <li key={index}>{error}</li>
              ))}
            </ul>
          </div>
        )}

        {/* Exibir mensagem de sucesso */}
        {success && <div className="alert alert-success">{success}</div>}

        <main className="card p-4 shadow-sm">
          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <input
                type="text"
                name="name"
                placeholder="Nome"
                className="form-control"
                value={formData.name}
                onChange={handleChange}
              />
            </div>
            <div className="mb-3">
              <input
                type="email"
                name="email"
                placeholder="Email"
                className="form-control"
                value={formData.email}
                onChange={handleChange}
              />
            </div>
            <div className="mb-3">
              <input
                type="password"
                name="password"
                placeholder="Senha"
                className="form-control"
                value={formData.password}
                onChange={handleChange}
              />
            </div>
            <div className="mb-3">
              <input
                type="password"
                name="password_confirmation"
                placeholder="Confirme a Senha"
                className="form-control"
                value={formData.password_confirmation}
                onChange={handleChange}
              />
            </div>
            <div className="w-50 mx-auto">
              <button type="submit" className="btn btn-primary w-100 my-1">Cadastrar</button>
            </div>
          </form>
        </main>
      </div>
    </Fragment>
  );
}

export default RegisterScreen;
