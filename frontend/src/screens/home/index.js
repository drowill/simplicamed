import React, { useState, useEffect, Fragment } from "react";
import ConsultasService from "../../services/ConsultaService";
import AuthService from "../../services/AuthService";
import { Helmet } from "react-helmet-async";
import ProfissionalService from "../../services/ProfissionalService";
import UserService from "../../services/UserService";
import { ToastContainer, toast } from "react-toastify";
import ImageClinica from '../../images/card-clinica.jpg';
import ImageProfissional from '../../images/card -profissionais.jpg';
const HomeScreen = () => {
  const [consultas, setConsultas] = useState([]);
  const [userLogado, setUserLogado] = useState(null);
  const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split("T")[0]);
  const [loading, setLoading] = useState(false);
  const [profissionais, setProfissionais] = useState([]);

  useEffect(() => {
    const fetchConsultas = async () => {
      setLoading(true);
      try {
        const data = await ConsultasService.getConsultas(selectedDate);
        setConsultas(data);
      } catch (error) {
        console.error("Erro ao carregar consultas", error);
      } finally {
        setLoading(false);
      }
    };

    const handleGetUser = async () => {
      try {
        const user = await UserService.getUser();
        console.log(user);
        setUserLogado(user);
      } catch (error) {
        console.error("Nenhum usuário logado", error);
      }
    };

    const fetchProfissionais = async () => {
      try {
        const response = await ProfissionalService.getProfissionais();
        if (Array.isArray(response.profissionais)) {
          setProfissionais(response.profissionais);
        } else {
          console.error("Os dados retornados não são uma array:", response.data);
        }
      } catch (error) {
        console.error("Erro ao carregar profissionais", error);
      }
    };

    fetchConsultas();
    fetchProfissionais();
    handleGetUser();
  }, [selectedDate]);

  const handleLogout = async () => {
    try {
      const response = await AuthService.logout();
      if (response.status === 200) {
        window.location.href = "/login";
      } else {
        toast.error("Não foi possível realizar o logout");
      }
    } catch (error) {
      toast.error("Erro ao realizar logout");
    }
  };

  const handleRedirect = () => {
    window.location.href = "/agenda";
  };

  const filteredConsultas = consultas.filter(consulta => consulta.data === selectedDate);

  return (
    <Fragment>
      <Helmet>
        <title>Home - SimplificaMed</title>
      </Helmet>

      <div className="main-screen">
        <ToastContainer />
        <section className="banner">
          <div className="banner-content">
            <h2>Seja bem-vindo!</h2>
            <p>Precisa agendar sua consulta e não pode ir até o consultório?</p>
            {userLogado && userLogado.permission_level !== 2 && (
              <button type="button" className="btn btn-light w-25" onClick={handleRedirect}>
                Agende Aqui
              </button>
            )}
            <button type="button" className="btn btn-light w-25" onClick={handleLogout}>
              Logout
            </button>
          </div>
        </section>

        <section className="appointments">
          <div className="container">
            <div className="row">
              <div className="col-md-6">
                <h3>Consultas do dia</h3>
                <div id="consultas-list">
                  {loading ? (
                    <p>Carregando consultas...</p>
                  ) : (
                    filteredConsultas.map((consulta) => (
                      <div key={consulta.id} className="consulta">
                        <h4>{consulta.title}</h4>
                        <p><strong>Idade:</strong> {consulta.idade}</p>
                        <p><strong>Descrição:</strong> {consulta.descricao}</p>
                        <p><strong>Data:</strong> {consulta.data}</p>
                        <p><strong>Horário:</strong> {consulta.horario}</p>
                        <p><strong>Status:</strong> {consulta.status === 1 ? "Ativa" : "Inativa"}</p>
                      </div>
                    ))
                  )}
                </div>
              </div>

              <div className="col-md-6">
                <h3>Selecione uma data</h3>
                <input
                  type="date"
                  id="calendar"
                  className="form-control"
                  value={selectedDate}
                  onChange={(e) => setSelectedDate(e.target.value)}
                />
              </div>
            </div>
          </div>
        </section>

        <section className="info-clinica">
          <div className="container">
            <h3>Informações sobre a clínica</h3>
            <div className="d-flex row">
              <div className="row col-12 py-3">
                <img src={ImageClinica} class="col-12 col-sm-6 col-md-4 img-fluid object-fit-cover" alt="Imagem da Clínica" />
                <div class="col-12 col-sm-6 col-md-8 ">
                  <h4>Um espaço amplo e agradável.</h4>
                  <p>A sala de recpção da clínica passou por uma recente reformulação
                    com o objetivo de oferecer mais conforto aos pacientes durante o tempo de espera pelas consultas.</p>
                  <span>Novembro, 2024</span>
                </div>
              </div>
              <div className="row col-12 py-3">
                <img src={ImageProfissional} class="col-12 col-sm-6 col-md-4 img-fluid object-fit-cover" alt="Imagem da Clínica" />
                <div class="col-12 col-sm-6 col-md-8">
                  <h4>Equipe preparada para te atender.</h4>
                  <p>A clínica conta com uma equipe de profissionais altamente qualificados,
                    comprometidos em oferecer um atendimentode excelência para garantir a melhor experiência a cada paciente.</p>
                  <span>Novembro, 2024</span>
                </div>
              </div>
            </div>
          </div>
        </section>


        <section className="property-listings">
          <div className="container">
            <div className="d-flex gap-2 mb-5">
              <h2>Profissionais da Clínica</h2>
            </div>
            <div className="d-flex container">
              <div className="row">
                {Array.isArray(profissionais) && profissionais.length === 0 ? (
                  <p>Nenhum profissional cadastrado no momento.</p>
                ) : (
                  profissionais.map((profissional) => (
                    <div key={profissional.id} className="col-md-6 col-lg-4 mb-4">
                      <div className="card">
                        <img src={profissional.foto} className="card-img-top" alt={profissional.name} />
                        <div className="card-body">
                          <h5 className="card-title">{profissional.name}</h5>
                          <p className="card-text">{profissional.especialidade}</p>
                          <a href={`/profissionais/${profissional.id}`} className="btn btn-primary">Ver Perfil</a>
                        </div>
                      </div>
                    </div>
                  ))
                )}
              </div>
            </div>
          </div>
        </section>
      </div>
    </Fragment>
  );
};

export default HomeScreen;