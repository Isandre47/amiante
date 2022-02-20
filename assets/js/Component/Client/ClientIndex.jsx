import React, {useEffect, useState} from "react";
import axios from "axios";
import {Link} from "react-router-dom";

function ClientIndex () {

  const [clients, setClients] = useState([]);

  useEffect(() => {
    getClients();
  }, [])

  function getClients() {
    axios.get('/api/client/index').then(clients => {
      console.log('page client', clients.data)
      setClients(clients.data.clients)
    })
  }

  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>Index des clients</h1>
          </div>
        </div>
        <hr/>
        <Link to={'/client/add'} className={'nav-link'} >Ajouter un client</Link>
        <div className={'row m-3'}>
          <table className={'table table-striped table-hover'}>
            <thead>
            <tr>
              <td>Nom</td>
              <td>Chantier géré</td>
              <td>Gestion</td>
            </tr>
            </thead>
            <tbody>
            {
              clients.map(client =>
                  <tr key={client.id}>
                    <td>{client.name}</td>
                    <td>{client.site.map(chantier =>
                        <span key={chantier.id}>{chantier.name} <br/></span>
                    )}
                    </td>
                    <td>
                      <Link to={`/client/edit/${client.id}`} className={'nav-link'} edit={'true'}>Editer</Link>
                      -
                      <Link to={`/client/show/${client.id}`} className={'nav-link'}> Plus d'infos... {client.id}</Link>
                    </td>
                  </tr>
              )
            }
            </tbody>
          </table>
        </div>
      </div>
  )
}

export default ClientIndex
