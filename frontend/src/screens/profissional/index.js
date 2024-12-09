import React, { useEffect, useState, Fragment } from "react";
import ProfissionalService from "../../services/ProfissionalService";
import { Helmet } from "react-helmet-async";
import { Link, useNavigate } from "react-router-dom";
import { ToastContainer, toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';

const ProfissionaisScreen = () => {
  const [profissionais, setProfissionais] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchProfissionais = async () => {
      try {
        const data = await ProfissionalService.getProfissionaisAll();
        console.log(data.profissionais);
        setProfissionais(data.profissionais);
      } catch (error) {
        console.error("Erro ao carregar profissionais", error);
      } finally {
        setLoading(false);
      }
    };

    fetchProfissionais();
  }, []);

  const handleDelete = (id) => {
    toast(
      <div>
        <p>Tem certeza de que deseja deletar este profissional?</p>
        <button className="btn btn-danger" onClick={() => confirmDeletion(id)}>
          Confirmar
        </button>
      </div>,
      { autoClose: false, closeOnClick: false }
    );
  };

  const confirmDeletion = async (id) => {
    toast.dismiss();
    try {
      await ProfissionalService.deleteProfissional(id);
      toast.success("Profissional deletado com sucesso!");
      setProfissionais(profissionais.filter(profissional => profissional.id !== id)); // Atualiza a lista sem o profissional deletado
    } catch (error) {
      console.error("Erro ao deletar o profissional:", error);
      toast.error("Erro ao deletar o profissional. Tente novamente.");
    }
  };

  if (loading) return <p>Carregando...</p>;

  return (
    <Fragment>
      <Helmet><title>Profissionais Cadastrados</title></Helmet>
      <ToastContainer />
      <div className="container pt-5 col-md-8 offset-md-2">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h3>Profissionais cadastrados</h3>
          <a href="/profissionais/cadastrar" className="btn btn-primary" >
            Cadastrar
          </a>
        </div>
        {profissionais.length === 0 ? (
          <p>Nenhum profissional cadastrado no momento.</p>
        ) : (
          <table className="table table-striped">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              {profissionais.map((profissional) => (
                <tr key={profissional.id}>
                  <td>{profissional.name}</td>
                  <td>{profissional.email}</td>
                  <td>
                    <Link to={`/profissionais/${profissional.id}`} className="btn btn-info btn-sm me-2">Ver</Link>
                    <a href={`/profissional/editar/${profissional.id}`} className="btn btn-warning btn-sm me-2">Editar</a>
                    <button className="btn btn-danger btn-sm" onClick={() => handleDelete(profissional.id)}>Deletar</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>
    </Fragment>
  );
};

export default ProfissionaisScreen;
