import React, { Fragment } from "react";
import {Header, Footer} from "./components/";
import Router from "./routes";
import "./App.css";
function App() {
  return (
    <Fragment>
      <Header />
      <Router />
      <Footer />
    </Fragment>
  );
}

export default App;
