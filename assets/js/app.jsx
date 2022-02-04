import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Navbar from "./Component/Navbar";
import {BrowserRouter, Link, Route, Routes} from "react-router-dom";
import Client from "./Component/Client";
import Dashboard from "./Component/Dashboard";
import UserIndex from "./Component/User/UserIndex";
import UserShow from "./Component/User/UserShow";
import UserAdd from "./Component/User/UserAdd";
import Site from "./Component/Site";
import Category from './Component/Category';
import Equipment from "./Component/Equipment";
import AnalysisInitial from "./Component/AnalysisInitial";
import AnalysisWithdrawn from "./Component/AnalysisWithdrawn";
import AnalysisFallback from "./Component/AnalysisFallback";
import Process from "./Component/Process";
import Mask from "./Component/Mask";

function App() {
      return (
          <div className={'container-fluid'}>
            <div className={'bg-light'}>
              <BrowserRouter>
                <div className="row">
                  <Navbar />
                  <div className={'col-9 shadow bg-light'}>
                    <br/>
                    <Routes>
                      <Route path={'/dashboard'} element={<Dashboard />}/>
                      <Route path={'/users'} element={<UserIndex />}/>
                      <Route path={'/api/user/:userId'} element={<UserShow />}/>
                      <Route path={'/user/add'} element={<UserAdd />}/>
                      <Route path={'/clients'} element={<Client />}/>
                      <Route path={'/chantiers'} element={<Site />}/>
                      <Route path={'/materiels'} element={<Equipment />}/>
                      <Route path={'/categories'} element={<Category />}/>
                      <Route path={'/analyse-initiale'} element={<AnalysisInitial />}/>
                      <Route path={'/analyse-retrait'} element={<AnalysisWithdrawn />}/>
                      <Route path={'/analyse-repli'} element={<AnalysisFallback />}/>
                      <Route path={'/processus'} element={<Process />}/>
                      <Route path={'/masques'} element={<Mask />}/>
                    </Routes>
                  </div>
                </div>
              </BrowserRouter>
            </div>
          </div>
      )
}

ReactDOM.render(<App />, document.getElementById('root'));
