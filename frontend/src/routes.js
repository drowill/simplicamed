import React from "react";
import { Route, BrowserRouter, Routes } from "react-router-dom";
import { 
  HomeScreen, 
  LoginScreen, 
  ProfileScreen, 
  RegisterScreen, 
  AgendamentoScreen, 
  ConsultaScreen, 
  ConsultaDetalheScreen, 
  ProfissionaisScreen,
  ProfissionalCreate,
  ProfissionalDetails,
  ProfissionalUpdate,
  MinhasConsultasScreen,
} from "./screens";
import { HelmetProvider } from "react-helmet-async";
import PrivateRouter from "./components/Routes/PrivateRouter";

function Router() {
  return (
    <HelmetProvider>
      <BrowserRouter>
        <Routes>
          <Route exact path="/" element={<LoginScreen />} />
          <Route exact path="/minhas-consultas" element={<PrivateRouter><MinhasConsultasScreen/> </PrivateRouter>} />
          <Route exact path="/login" element={<LoginScreen />} />
          <Route exact path="/register" element={<RegisterScreen />} />
          <Route exact path="/home" element={<PrivateRouter><HomeScreen/></PrivateRouter>}/>
          <Route exact path="/profile" element={<PrivateRouter><ProfileScreen/></PrivateRouter>}/>
          <Route exact path="/agenda" element={<PrivateRouter><AgendamentoScreen/></PrivateRouter>}/>
          <Route exact path="/consultas" element={<PrivateRouter><ConsultaScreen/></PrivateRouter>}/>
          <Route exact path="/consulta/:id" element={<PrivateRouter><ConsultaDetalheScreen/></PrivateRouter>} />
          <Route exact path="/profissionals" element={<PrivateRouter><ProfissionaisScreen/></PrivateRouter>}/>
          <Route exact path="/profissionais/cadastrar" element={<PrivateRouter><ProfissionalCreate/></PrivateRouter>}/>
          <Route exact path="/profissional/editar/:id" element={<PrivateRouter><ProfissionalUpdate/></PrivateRouter>}/>
          <Route exact path="/profissionais/:id" element={<PrivateRouter><ProfissionalDetails/></PrivateRouter>}/>
        </Routes>
      </BrowserRouter>
    </HelmetProvider>
  );
}

export default Router;
