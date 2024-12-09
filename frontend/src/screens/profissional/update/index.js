import React, { useEffect, useState, Fragment } from "react";
import { useParams } from "react-router-dom";
import ProfissionalService from "../../../services/ProfissionalService"; // Certifique-se de que o serviço está configurado corretamente
import { Helmet } from "react-helmet-async";
import InputMask from "react-input-mask";

const ProfissionalUpdate = () => {
  const { id } = useParams(); // Pega o ID do profissional da URL
  const [formData, setFormData] = useState({
    name: "",
    endereco: "",
    cpf: "",
    telefone: "",
    data_nascimento: "",
    password: "",
    email: ""
  });

  const [errors, setErrors] = useState([]);
  const [successMessage, setSuccessMessage] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProfissional = async () => {
      try {
        const response = await ProfissionalService.getProfissionalById(id);
        setFormData(response.profissional);
      } catch (error) {
        console.error("Erro ao carregar dados do profissional:", error);
        setErrors(["Erro ao carregar dados do profissional. Tente novamente."]);
      } finally {
        setLoading(false);
      }
    };

    fetchProfissional();
  }, [id]);

  // Atualiza os dados do formulário
  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  // Envia os dados do formulário
  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors([]);
    setSuccessMessage("");

    try {
      await ProfissionalService.updateProfissional(id, formData);
      setSuccessMessage("Informações do profissional atualizadas com sucesso!");
    } catch (error) {
      if (error.response && error.response.data.errors) {
        setErrors(Object.values(error.response.data.errors).flat());
      } else {
        setErrors(["Erro ao atualizar o profissional. Tente novamente."]);
      }
    }
  };

  if (loading) {
    return <p>Carregando...</p>;
  }

  return (
    <Fragment>
      <Helmet><title>Atualizar Profissional - SimplificaMed</title></Helmet>
      <div className="col-md-6 offset-md-3">
        <h1>Atualizar Profissional</h1>

        {errors.length > 0 && (
          <div className="alert alert-danger">
            <ul>
              {errors.map((error, index) => (
                <li key={index}>{error}</li>
              ))}
            </ul>
          </div>
        )}

        {successMessage && (
          <div className="alert alert-success">{successMessage}</div>
        )}

        <form onSubmit={handleSubmit}>
          {/* Nome */}
          <div className="form-group mb-3">
            <label htmlFor="name">Nome</label>
            <input
              type="text"
              id="name"
              name="name"
              className="form-control"
              value={formData.name}
              onChange={handleChange}
              required
            />
          </div>

          {/* Endereço */}
          <div className="form-group mb-3">
            <label htmlFor="endereco">Endereço</label>
            <input
              type="text"
              id="endereco"
              name="endereco"
              className="form-control"
              value={formData.endereco}
              onChange={handleChange}
              required
            />
          </div>

          {/* CPF */}
          <div className="form-group mb-3">
            <label htmlFor="cpf">CPF</label>
            <InputMask
              type="text"
              id="cpf"
              name="cpf"
              className="form-control"
              value={formData.cpf}
              onChange={handleChange}
              mask="999.999.999-99"
              required
            />
          </div>

          {/* Telefone */}
          <div className="form-group mb-3">
            <label htmlFor="telefone">Telefone</label>
            <InputMask
              type="text"
              id="telefone"
              name="telefone"
              className="form-control"
              value={formData.telefone}
              onChange={handleChange}
              mask="(99) 99999-9999"
              required
            />
          </div>

          <div className="form-group mb-3">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              className="form-control"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>
          <div className="form-group mb-3">
            <label htmlFor="password">Senha</label>
            <input
              type="password"
              id="password"
              name="password"
              className="form-control"
              value={formData.password}
              onChange={handleChange}
              required
            />
          </div>
          <div className="form-group mb-3">
            <label htmlFor="data_nascimento">Data de Nascimento</label>
            <input
              type="date"
              id="data_nascimento"
              name="data_nascimento"
              className="form-control"
              value={formData.data_nascimento}
              onChange={handleChange}
              required
            />
          </div>

          {/* Botão de envio */}
          <button type="submit" className="btn btn-primary">
            Atualizar profissional
          </button>
        </form>
      </div>
    </Fragment>
  );
};

export default ProfissionalUpdate;
