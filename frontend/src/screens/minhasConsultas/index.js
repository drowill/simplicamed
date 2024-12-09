import React, { useState, useEffect } from "react";
import UserService from "../../services/UserService";
import ConsultaService from "../../services/ConsultaService";

const MinhasConsultasScreen = () => {
  const [user, setUser] = useState({});
  const [consultas, setConsultas] = useState([]);
  const [error, setError] = useState(null);
  const [search, setSearch] = useState({ date: "", name: "", status: "" });
  const [currentPage, setCurrentPage] = useState(1);
  const [itemsPerPage] = useState(2);

  useEffect(() => {
    const fetchConsultas = async (userId) => {
      try {
        const data = await ConsultaService.getConsultaById(userId);
        console.log(data);
        setConsultas(data);
      } catch (err) {
        setError("Erro ao obter as consultas");
        console.error(err);
      }
    };

    const handleGetUser = async () => {
      try {
        const userLogado = await UserService.getUser();
        setUser(userLogado);
        if (userLogado && userLogado.id) {
          fetchConsultas(userLogado.id);
        }
      } catch (error) {
        console.error("Nenhum usuário logado", error);
        setError("Erro ao carregar os dados do usuário");
      }
    };

    handleGetUser();
  }, []);

  const handleSearchChange = (e) => {
    const { name, value } = e.target;
    setSearch({ ...search, [name]: value });
  };

  const filteredConsultas = consultas.filter((consulta) => {
    return (
      (search.date === "" || consulta.data === search.date) &&
      (search.name === "" || consulta.titulo.toLowerCase().includes(search.name.toLowerCase())) &&
      (search.status === "" || consulta.status.toString() === search.status)
    );
  });

  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentItems = filteredConsultas.slice(indexOfFirstItem, indexOfLastItem);

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  return (
    <div className="card mx-4 px-4 my-2">
                    <div className="card-body">

      <h1>Minhas Consultas</h1>
      {error && <p className="alert alert-danger">{error}</p>}
      <div className="mb-4">
        <input
          type="date"
          name="date"
          placeholder="Data"
          value={search.date}
          onChange={handleSearchChange}
          className="form-control mb-2"
        />
        <input
          type="text"
          name="name"
          placeholder="Nome"
          value={search.name}
          onChange={handleSearchChange}
          className="form-control mb-2"
        />
        <select
          name="status"
          value={search.status}
          onChange={handleSearchChange}
          className="form-control mb-2"
        >
          <option value="">Todos os Status</option>
          <option value="1">Pendente</option>
          <option value="0">Inativa</option>
        </select>
      </div>
      </div>
      {filteredConsultas.length === 0 && !error ? (
        <p>Nenhuma consulta encontrada.</p>
      ) : (
        <ul>
          {currentItems.map((consulta) => (
            <li className="card mb-3" key={consulta.id}>
              <div className="card-body">
                <h5 className="card-title">Titulo: {consulta.titulo}</h5>
                <p className="card-text">Data:{new Date(consulta.data).toLocaleDateString()} </p>
                {consulta.status === 1 ? (
                  <p className="card-text">
                    <button type="button" className="btn btn-warning">Pendente</button>
                  </p>
                ) : (
                  <p className="card-text">
                    <small className="text-body-secondary">Inativa</small>
                  </p>
                )}
              </div>
            </li>
          ))}
        </ul>
      )}
      <nav class="mb-4 justify-content-center">
        <ul className="pagination">
          {Array.from({ length: Math.ceil(filteredConsultas.length / itemsPerPage) }, (_, i) => (
            <li key={i + 1} className="page-item">
              <a onClick={() => paginate(i + 1)} href="#!" className="page-link">
                {i + 1}
              </a>
            </li>
          ))}
        </ul>
      </nav>
    </div>
  );
};

export default MinhasConsultasScreen;
