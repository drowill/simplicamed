import React, { useState, useEffect, Fragment } from "react";
import ConsultaService from "../../services/ConsultaService";
import { Helmet } from "react-helmet-async";
import ReactPaginate from 'react-paginate';
import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer, toast } from "react-toastify";
import UserService from "../../services/UserService";

const ConsultaScreen = () => {
  const [consultas, setConsultas] = useState([]);
  const [user, setUser] = useState(null);
  const [search, setSearch] = useState("");
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 10;

  useEffect(() => {

    const fetchConsultas = async () => {
      try {
        const data = await ConsultaService.getConsultasAll();
        setConsultas(data);
      } catch (err) {
        console.error(err);
      }
    };

    const handleGetUser = async () => {
      try {
        const userLogado = await UserService.getUser();
        setUser(userLogado);
      } catch (error) {
        console.error("Nenhum usuário logado", error);
      }
    };

    fetchConsultas();
    handleGetUser();
  }, []);

  const handlePageClick = ({ selected }) => {
    setCurrentPage(selected);
  };

 
  // Filtrando consultas pelo termo de pesquisa
  const filteredConsultas = consultas.filter(consulta => 
    consulta.titulo?.toLowerCase().includes(search.toLowerCase()) ||
    consulta.name?.toLowerCase().includes(search.toLowerCase()) ||
    consulta.endereco?.toLowerCase().includes(search.toLowerCase()) ||
    consulta.descricao?.toLowerCase().includes(search.toLowerCase()) ||
    consulta.data?.toLowerCase().includes(search.toLowerCase())
  );

  // Calcular a lista de consultas para a página atual
  const offset = currentPage * itemsPerPage;
  const currentItems = filteredConsultas.slice(offset, offset + itemsPerPage);
  console.log(currentItems);
  return (
    <Fragment>
      <Helmet>
        <title>Consultas</title>
      </Helmet>

      <div className="container mt-5">
        <ToastContainer />
        {error && <div className="alert alert-danger">{error}</div>}

        <div className="row mb-4">
          <div className="col-md-6 offset-md-3">
            <h1>Busque sua consulta</h1>
            <input
              type="text"
              className="form-control"
              placeholder="Buscar..."
              value={search}
              onChange={(e) => setSearch(e.target.value)} // Atualiza o estado de pesquisa
            />
          </div>
        </div>

        <div className="row">
          <div className="col-md-12">
            <h1>Lista de Consultas</h1>

            <div className="card-body">
              <div className="table-responsive">
                <table className="table table-striped table-vcenter table-bordered hover">
                  <thead>
                    <tr className="text-center">
                      <th>Título</th>
                      <th>Nome</th>
                      <th>Idade</th>
                      <th>Endereço</th>
                      <th>Descrição</th>
                      <th>Data</th>
                      <th>Hora</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    {currentItems.length === 0 ? (
                      <tr>
                        <td colSpan="9">Nenhuma consulta encontrada.</td>
                      </tr>
                    ) : (
                      currentItems.map((consulta) => (
                        <tr key={consulta.id}>
                          <td>{consulta.titulo}</td>
                          <td>{consulta.cliente ? consulta.cliente.name : "Nome do usuário não encontrado"}</td>
                          <td>{consulta.idade} Anos</td>
                          <td>{consulta.cliente ? consulta.cliente.endereco : "Nenhum endereço encontrado"}</td>
                          <td>{consulta.descricao}</td>
                          <td>{new Date(consulta.data).toLocaleDateString()}</td>
                          <td>{consulta.horario}</td>
                          <td>
                            {consulta.status === 1 && (
                              <span className="badge text-bg-warning">Pendente</span>
                            )}
                            {consulta.status === 2 && (
                              <span className="badge text-bg-primary">Confirmado</span>
                            )}
                            {consulta.status === 3 && (
                              <span className="badge text-bg-danger">Rejeitado</span>
                            )}
                            {consulta.status === 4 && (
                              <span className="badge text-bg-danger">Cancelado</span>
                            )}
                            {consulta.status === 5 && (
                              <span className="badge text-bg-success">Finalizado</span>
                            )}
                          </td>
                          <td>
                            <a href={`/consulta/${consulta.id}`} className="btn btn-primary btn-sm me-2">
                              Visualizar
                            </a>
                          </td>
                        </tr>
                      ))
                    )}
                  </tbody>
                </table>
              </div>
            </div>

            <ReactPaginate
              previousLabel={"Anterior"}
              nextLabel={"Próxima"}
              breakLabel={"..."}
              breakClassName={"break-me"}
              pageCount={Math.ceil(filteredConsultas.length / itemsPerPage)}
              marginPagesDisplayed={2}
              pageRangeDisplayed={5}
              onPageChange={handlePageClick}
              containerClassName={"pagination justify-content-center"}
              subContainerClassName={"pages pagination"}
              pageClassName={"page-item"}
              pageLinkClassName={"page-link"}
              activeClassName={"active"}
              disabledClassName={"disabled"}
              previousClassName={"page-item"}
              previousLinkClassName={"page-link"}
              nextClassName={"page-item"}
              nextLinkClassName={"page-link"}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
};

export default ConsultaScreen;
