import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import ProfissionalService from "../../../services/ProfissionalService";
import { Helmet } from "react-helmet-async";
import { ToastContainer, toast } from "react-toastify";
import 'react-toastify/ReactToastify.css';

const ProfissionalDetails = () => {
  const { id } = useParams(); // Pega o ID do profissional da URL
  const navigate = useNavigate();
  const [profissional, setProfissional] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchProfissional = async () => {
      try {
        const response = await ProfissionalService.getProfissionalById(id);
        setProfissional(response.profissional);
      } catch (error) {
        console.error("Erro ao carregar dados do profissional:", error);
        alert("Erro ao carregar dados do profissional. Tente novamente.");
        navigate("/profissionais"); // Retorna para a lista de profissionais em caso de erro
      } finally {
        setLoading(false);
      }
    };

    fetchProfissional();
  }, [id, navigate]);

  const handleDelete = () => {
    toast(
      <div>
        <p>Tem certeza de que deseja deletar este profissional?</p>
        <button className="btn btn-danger" onClick={confirmDeletion}>
          Confirmar
        </button>
      </div>,
      { autoClose: false, closeOnClick: false }
    );
  };

  const confirmDeletion = async () => {
    toast.dismiss();
    try {
      await ProfissionalService.deleteProfissional(id);
      toast.success("Profissional deletado com sucesso!");
      navigate("/home"); 
    } catch (error) {
      console.error("Erro ao deletar o profissional:", error);
      toast.error("Erro ao deletar o profissional. Tente novamente.");
    }
  };

  if (loading) {
    return <p>Carregando...</p>;
  }

  if (!profissional) {
    return <p>Nenhum profissional encontrado.</p>;
  }

  return (
    <>
      <Helmet>
        <title>Detalhes do Profissional - SimplificaMed</title>
      </Helmet>
      <ToastContainer />
      <div className="container mt-5">
        <h2>Detalhes do Profissional</h2>

        <div className="card">
          <div className="card-header">
            <h3>{profissional.name}</h3>
          </div>
          <div className="card-body">
            <p><strong>Nome do Profissional:</strong> {profissional.name}</p>
            <p><strong>Especialização:</strong> {profissional.tipo}</p>
            <p><strong>Endereço:</strong> {profissional.endereco}</p>
            <p><strong>CPF:</strong> {profissional.cpf}</p>
            <p><strong>Telefone:</strong> {profissional.telefone}</p>
          </div>
        </div>

        <button className="btn btn-primary mt-3" onClick={() => navigate("/home")}>
          Voltar
        </button>
        <button className="btn btn-danger mt-3 ms-3" onClick={handleDelete}>
          Deletar
        </button>
      </div>
    </>
  );
};

export default ProfissionalDetails;
