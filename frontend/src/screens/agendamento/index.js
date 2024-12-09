import React, { useState, Fragment, useEffect } from "react";
import AgendamentoService from "../../services/AgendamentoService"; // Importando o serviço
import { Helmet } from "react-helmet-async";
import UserService from "../../services/UserService";
import { toast, ToastContainer } from "react-toastify";

const AgendamentoScreen = () => {
  const [user, setUser] = useState(null);
  const [formData, setFormData] = useState({
    titulo: "",
    name: "Nenhum usuário logado", 
    idade: "",
    endereco: "Endereço de usuário não cadastrado", 
    descricao: "",
    data: "",
    horario: "",
  });

  const [errors, setErrors] = useState([]);
  const [loading, setLoading] = useState(false);

  // Função para tratar alterações no formulário
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  useEffect(() => {
    const handleGetUser = async () => {
      try {
        const userLogado = await UserService.getUser();
        setUser(userLogado);
        setFormData((prevData) => ({
          ...prevData,
          name: userLogado.name,
          endereco: userLogado.endereco || "Endereço de usuário não cadastrado",
        }));
      } catch (error) {
        console.error("Nenhum usuário logado", error);
      }
    };

    handleGetUser();
  }, []);

  // Função para tratar o envio do formulário
  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors([]);

    try {
      // Usando o AgendamentoService para cadastrar a consulta
      const response = await AgendamentoService.post(formData);
      if(response.status === 201){
        toast.success("Consulta cadastrada com sucesso!");
        setTimeout(() => { window.location.href = "/home"; }, 3000);
      }else{
        toast.error("Ocorreu um erro ao cadastrar a consulta, verifique se os campos estão preenchidos e se você está logado no sistema!");
      }
    } catch (error) {
      // Exibe erros do servidor, caso existam
      if (error.response && error.response.data.errors) {
        setErrors(error.response.data.errors);
        toast.error("Ocorreu um erro ao cadastrar a consulta, verifique se os campos estão preenchidos e se você está logado no sistema!");
      } else {
        toast.error("Erro ao cadastrar a consulta.");
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <Fragment>
      <Helmet>
        <title>Consultas - SimplificaMed</title>
      </Helmet>
      <ToastContainer />
      <div className="pt-5 col-md-6 offset-md-3 pb-5">
        {/* Exibindo erros */}
        {errors.length > 0 && (
          <div className="alert alert-danger">
            <ul>
              {errors.map((error, index) => (
                <li key={index}>{error}</li>
              ))}
            </ul>
          </div>
        )}

        <h1>Crie sua Consulta</h1>
        <form onSubmit={handleSubmit}>
          {/* Título da consulta */}
          <div className="form-group mb-3">
            <label htmlFor="titulo">Título da Consulta</label>
            <input
              type="text"
              name="titulo"
              className="form-control"
              value={formData.titulo}
              onChange={handleChange}
              required
            />
          </div>

          {/* Nome do paciente */}
          <div className="form-group mb-3">
            <label htmlFor="name">Nome do Paciente</label>
            <input
              type="text"
              name="name"
              className="form-control"
              value={formData.name}
              onChange={handleChange}
              disabled
              required
            />
          </div>

          {/* Idade */}
          <div className="form-group mb-3">
            <label htmlFor="idade">Idade</label>
            <input
              type="number"
              name="idade"
              min={18}
              className="form-control"
              value={formData.idade}
              onChange={handleChange}
              required
            />
          </div>

          {/* Endereço */}
          <div className="form-group mb-3">
            <label htmlFor="endereco">Endereço</label>
            <input
              type="text"
              name="endereco"
              className="form-control"
              value={formData.endereco}
              onChange={handleChange}
              disabled
            />
          </div>

          {/* Descrição */}
          <div className="form-group mb-3">
            <label htmlFor="descricao">Descrição da Consulta</label>
            <textarea
              name="descricao"
              className="form-control"
              rows="5"
              value={formData.descricao}
              onChange={handleChange}
              required
            ></textarea>
          </div>

          {/* Data da Consulta */}
          <div className="form-group mb-3">
            <label htmlFor="data">Data da Consulta</label>
            <input
              type="date"
              name="data"
              className="form-control"
              value={formData.data}
              onChange={handleChange}
              required
            />
          </div>

          {/* Horário da Consulta */}
          <div className="form-group mb-3">
            <label htmlFor="horario">Horário da Consulta</label>
            <input
              type="time"
              name="horario"
              className="form-control"
              value={formData.horario}
              onChange={handleChange}
              required
            />
          </div>

          {/* Botão de submissão */}
          <div className="text-center">
            <button type="submit" className="btn btn-primary" disabled={loading}>
              {loading ? "Cadastrando..." : "Cadastrar Consulta"}
            </button>
          </div>
          
        </form>
      </div>
    </Fragment>
  );
};

export default AgendamentoScreen;
