import React, {Component} from "react";

class Dashboard extends Component {
  render() {
    return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{ height: '4rem'}}>
            <div className={'col-12 text-center'}>
              <h1>Infos générales</h1>
            </div>
          </div>
          <hr/>
          <div className={'row justify-content-around m-3'}>
            <div className={'col-4'}>
              nb utilisateurs dont tant de client
            </div>
            <div className={'col-4'}>
              tant de matos
            </div>
            <div className={'col-4'}>
              que dalle pour le moment
            </div>
          </div>
          <hr/>
          <div className={'row justify-content-around m-3'}>
            <div className={'col-10'}>
              nb chantiers
              <ul>
                Liste des chantiers et des users
              </ul>
            </div>
          </div>
        </div>
    )
  }
}

export default Dashboard
