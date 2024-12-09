import React from "react";
import { useNavigate } from "react-router-dom";

const ProfissionaisList = ({ profissionais }) => {
  const navigate = useNavigate();

  if (profissionais.length === 0) {
    return <p>Nenhum profissional cadastrado ainda</p>;
  }

  return (
    <ul className="list-group">
      {profissionais.map((profissional) => (
        <li key={profissional.id} className="list-group-item">
          <strong>{profissional.name}</strong> ---{" "}
          <span className="badge text-bg-primary">{profissional.tipo}</span>
          <span className="truncate">Telefone: {profissional.telefone}</span>
          <small className="text-muted">CPF: {profissional.cpf}</small>
          <div className="d-flex justify-content-end">
            <button
              onClick={() => navigate(`/profissionais/${profissional.id}`)}
              className="btn btn-primary me-2"
            >
              Visualizar
            </button>
          </div>
        </li>
      ))}
    </ul>
  );
};

export default ProfissionaisList;
