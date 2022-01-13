import React, {Component, useEffect, useState} from "react";
import axios from "axios";

function Dashboard() {

  const [users, setUsers] = useState([])
  const [sites, setSites] = useState([])
  const [equipments, setEquipments] = useState([])

  useEffect(() => {
    getUsers();
  }, [])

  function getUsers() {
    axios.get('/dashboard_data').then(dash => {
      setUsers(dash.data.users)
      setEquipments(dash.data.equipments)
      setSites(dash.data.sites)
    }).catch(error => {
      console.log('error', users)
      if (error.response) {
        console.log('error response', error.response);
      } else if (error.request) {
        console.log('error request', error.request);
      } else {
        console.log('error message', error.message);
      }
    })
  }

    return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{ height: '4rem'}}>
            <div className={'col-12 text-center'}>
              <h1>Infos générales</h1>
            </div>
          </div>
          <hr/>
          <div>
            <div className={'row justify-content-around m-3'}>
              <div className={'col-4'}>
                nb utilisateurs dont tant de client {users.length}
              </div>
              <div className={'col-4'}>
                tant de matos: {equipments.length}
              </div>
              <div className={'col-4'}>
                Non renseignée
              </div>
            </div>
            <hr/>
            {sites.length} chantiers
            <br/>
            <div className={'row justify-content-around m-3'}>
              {
                sites.map(site =>
                    <div className="col-md-10 offset-md-1 row-block" key={site.s_id}>
                      <ul id="sortable" className={'list-unstyled'}>
                        <li>
                          <div className="media">
                            <div className="media-body">
                              <p>{site.s_name} -
                                {site.nbUsers > 0 ? site.nbUsers : 'aucun'} utilisateurs affecté !
                              </p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                )
              }
            </div>
          </div>
        </div>
    )
}

export default Dashboard
