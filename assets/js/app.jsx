import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Navbar from "./Component/Navbar";
import {BrowserRouter, Link, Route, Routes} from "react-router-dom";
import AnotherPage from "./Component/AnotherPage";
import Dashboard from "./Component/Dashboard";
import User from "./Component/User";

class App extends Component {
    render() {
      return (
          <div className={'container-fluid'}>
            <div className={'bg-secondary'}>
              <BrowserRouter>
                <div className="row">
                  <Navbar />
                  <div className={'col-9 shadow bg-light'}>
                    <br/>
                    <Routes>
                      <Route path={'/another-page'} element={<AnotherPage />}/>
                      <Route path={'/dashboard'} element={<Dashboard />}/>
                      <Route path={'/users'} element={<User />}/>
                    </Routes>
                  </div>
                </div>
              </BrowserRouter>
            </div>
          </div>
      )
    }
}

ReactDOM.render(<App />, document.getElementById('root'));
