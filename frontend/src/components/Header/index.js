import React, { useState, useEffect } from "react";
import UserService from "../../services/UserService";
import ImageLogo from '../../images/logo-simplifica.png';
const Header = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const handleGetUser = async () => {
      try {
        const userLogado = await UserService.getUser();
        setUser(userLogado);
      } catch (error) {
        console.error("Nenhum usuário logado", error);
      }
    };
    handleGetUser();
  }, []);

  return (
    <header>
      <div className="logo" onClick={() => window.location.href = "/home"}>
      <img src={ImageLogo} alt="Logo Simflificamed"/>
        <h1>Simplifica Med</h1>
      </div>

      <nav>
        <ul>
          {user && user.name ? (
            <>
              <li>
                <a href="/home">Home</a>
              </li>
              {(user.permission_level !== 2) && (
                 <>
                    <li>
                      <a href="/agenda">Agenda</a>
                    </li>                    
                  </>
              )}
              {user.permission_level === 2 && (
                 <>
                    <li>
                      <a href="/profissionals">Profissionais</a>
                    </li>

                    <li>
                    <a href="/consultas">Consultas</a>
                    </li>
                    
                  </>
              )}
              {user.permission_level === 1 && (
                <li>
                  <a href="/consultas">Consultas</a>
                </li>
              )}
              {user.permission_level === 0 && (
                <li>
                  <a href="/minhas-consultas">Minhas Consultas</a>
                </li>
              )}
            </>
          ) : (
            <li>
              <a href="/register" className="hover">
                Registrar
              </a>
            </li>
          )}
        </ul>
      </nav>

      {user && user.name ? (
          <div className="user-icon">
              <button>
                  <a href="/profile">{user.name.charAt(0)}</a>
              </button>
          </div>
      ) : null}


    </header>
  );
};

export default Header;
