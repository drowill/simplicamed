import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import ConsultaService from "../../services/ConsultaService";
import { Helmet } from "react-helmet-async";
import ProfissionalService from "../../services/ProfissionalService";
import UserService from "../../services/UserService";
import { ToastContainer, toast } from "react-toastify";
import api from "../../services/api"; 

const ConsultaDetalheScreen = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [user, setUser] = useState();
  const [consulta, setConsulta] = useState(null);
  const [profissionais, setProfissionais] = useState([]);
  const [selectedProfissional, setSelectedProfissional] = useState("");
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const rejeitar = async (id) => {
    try {
      const data = await ConsultaService.rejectedConsulta(id);
      toast.success("Consulta rejeitada com sucesso!");
    } catch (error) {
      console.error(error);
      toast.error(error.response.data.message);
    }
  };

  const aceitar = async (id) => {
    try {
      const data = await ConsultaService.acceptedConsulta(id);
      toast.success("Consulta aceita com sucesso!");
    } catch (error) {
      
      console.error(error);
      toast.error(error.response.data.message);
    }
  };


  useEffect(() => {
    const handleGetUser = async () => {
      try {
        const response = await UserService.getUser();
        setUser(response);
      } catch (error) {
        console.error(error);
      }
    };

    const fetchProfissionais = async () => {
      try {
        const response = await ProfissionalService.getProfissionaisAll();
        setProfissionais(response.profissionais);
      } catch (error) {
        console.error(error);
      }
    };

    const fetchConsultaDetails = async () => {
      try {
        const consultaData = await ConsultaService.getConsultaId(id);
        console.log("consulta:", consultaData);
        setConsulta(consultaData);
      } catch (err) {
        console.error("Erro ao carregar dados:", err);
        setErrorMessage("Erro ao carregar os detalhes da consulta.");
      }
    };

    handleGetUser();
    fetchProfissionais();
    fetchConsultaDetails();
  }, [id]);

  const handleAssociarProfissional = async (e) => {
    e.preventDefault();
    try {
      const data = {
        prof: selectedProfissional // Corrigido para pegar diretamente o ID selecionado
      };
      console.log("prof:", selectedProfissional);
      const response = await ConsultaService.vincularProfissionalConsulta(consulta.id, data);
      console.log("profissional associado:", response);
      setSuccessMessage("Profissional associado com sucesso!");
    } catch (err) {
      console.error("Erro ao associar profissional:", err);
      setErrorMessage("Erro ao associar o profissional.");
    }
  };

  const handleAction = async (actionUrl) => {
    try {
      await api.post(actionUrl);
      setSuccessMessage("Ação concluída com sucesso!");
      navigate(0);
    } catch (err) {
      console.error("Erro ao executar ação:", err);
      setErrorMessage("Erro ao executar a ação.");
    }
  };

  if (!consulta) return <p>Carregando...</p>;

  console.log(consulta);
  return (
    <div className="container mt-5">
      <Helmet>
        <title>Detalhes da Consulta</title>
      </Helmet>

      {successMessage && <div className="alert alert-success">{successMessage}</div>}
      {errorMessage && <div className="alert alert-danger">{errorMessage}</div>}

      <h2>Detalhes da Consulta</h2>

      <div className="card mb-3">
        <div className="card-header">
          <h3>{consulta.titulo}</h3>
        </div>

        <div className="card-body">
          <p><strong>Nome:</strong> {consulta.cliente?.name}</p>
          <p><strong>Idade:</strong> {consulta.idade} anos</p>
          <p><strong>Descrição:</strong> {consulta.descricao}</p>
          <p><strong>Data da Consulta:</strong> {new Date(consulta.data).toLocaleDateString()}</p>
          <p><strong>Endereço:</strong> {consulta.cliente?.endereco ? consulta.cliente.endereco : "Nenhum endereço registrado"}</p>
          <p><strong>Horário da Consulta:</strong> {consulta.horario}</p>
          <p><strong>Status:</strong>
            {consulta.status === 1 && <span className="badge bg-warning">Pendente</span>}
            {consulta.status === 2 && <span className="badge bg-primary">Confirmado</span>}
            {consulta.status === 3 && <span className="badge bg-danger">Rejeitado</span>}
            {consulta.status === 4 && <span className="badge bg-danger">Cancelado</span>}
            {consulta.status === 5 && <span className="badge bg-success">Finalizado</span>}
          </p>

          <p><strong>Profissional Associado:</strong>
            {consulta.profissional
              ? `${consulta.profissional?.name} - ${consulta.profissional.tipo}`
              : "Nenhum profissional associado."
            }
          </p>
        </div>

        {consulta.status !== 4 && consulta.status !== 3 && user?.permission_level === 2 && (
          <div className="card-header">
            <h3>Associar um profissional</h3>
          </div>
        )}

        <div className="card-body">
          <form onSubmit={handleAssociarProfissional}>
            <div className="d-flex">
              {user?.permission_level === 2 && (
                <>
                  <select
                    name="profissional_id"
                    value={selectedProfissional}
                    onChange={(e) => setSelectedProfissional(e.target.value)}
                    className="form-control me-2"
                    disabled={!!consulta.profissional}
                  >
                    <option value="">Selecione um profissional</option>
                    {profissionais.map((profissional) => (
                      <option key={profissional.id} value={profissional.id}>
                        {profissional.name} - {profissional.tipo}
                      </option>
                    ))}
                  </select>

                  {!consulta.profissional && (
                    <button type="submit" className="btn btn-secondary">
                      Associar
                    </button>
                  )}
                </>
              )}
            </div>
          </form>
        </div>
      </div>

      <a href="#" onClick={() => navigate(-1)} className="btn btn-primary me-2">
        Voltar
      </a>

      {consulta.status !== 5 && consulta.profissional && (
        <>
          {consulta.status !== 2 && user?.permission_level === 2 && (
            <button
              className="btn btn-success me-2"
              onClick={() => handleAction(`/api/confirmar_consulta/${consulta.id}`)}
            >
              Confirmar Consulta
            </button>
          )}
          {consulta.status === 2 && (
            <button
              className="btn btn-success me-2"
              onClick={() => handleAction(`/api/finalizar_consulta/${consulta.id}`)}
            >
              Finalizar Consulta
            </button>
          )}
        </>
      )}

      {consulta.status === 1 && user?.permission_level === 1 && (
        <button
          className="btn btn-danger me-2"
          onClick={() => handleAction(`/api/rejeitar_consulta/${consulta.id}`)}
        >
          Rejeitar
        </button>
      )}

      {consulta.status === 1 && user?.permission_level === 1 && (
        <button
          className="btn btn-success me-2"
          onClick={() => aceitar(consulta.id)}
        >
          Aceitar
        </button>
      )}

      {!consulta.profissional && consulta.status !== 4 && consulta.status !== 3 && user?.permission_level === 2 && (
        <button
          className="btn btn-danger me-2"
          onClick={() => rejeitar(consulta.id)}
        >
          Cancelar Consulta
        </button>
      )}
    </div>
  );
};

export default ConsultaDetalheScreen;
