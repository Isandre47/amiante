import React, {useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import axios from "axios";

function ClientShow() {

  let client = useParams();
  const [clientInfo, setClientInfo] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    getClient();
  }, [])

  function getClient() {
    axios.get('/api/client/show/'+client.clientId).then((clientShow) => {
      console.log('client data', clientShow.data)
      setClientInfo(clientShow.data);
      setIsLoading(false);
    }).catch(error => {
      console.log('error', error)
      if (error.response) {
        console.log('error response', error.response);
      } else if (error.request) {
        console.log('error request', error.request);
      } else {
        console.log('error message', error.message);
      }
    })
  }

  if (isLoading) return 'Chargement en cours';
  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '10vh'}}>
          <div className="col-12 text-center">
            <h1>Salut {clientInfo.name}</h1>
          </div>
        </div>
        <hr/>
        <div className={'container'}>
          <div className={'row'}>
            <div className={'col-6'}>
              <h3>{clientInfo.user.firstname} {clientInfo.user.lastname}</h3>
              <hr/>
              <br/>
              {
                clientInfo.site.map((site) => (
                        <div key={site.id}>
                          <h4>Chantier: {site.name}</h4>
                          {site.zones.map((zone) => (
                                  <div key={zone.id}>Zone: {zone.category.name} <br/></div>
                              )
                          )}
                          <hr/>
                        </div>
                    )
                )
              }
            </div>
            {/*<div className={'col-4'}>*/}
            {/*  Historique : <br/>*/}
            {/*  {userInfo.history.map((item) => (*/}
            {/*      // console.log('date', new Date(item.date_arrived.date).toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }))*/}
            {/*      <div>*/}
            {/*        Nombre de chantiers: {userInfo.length} <br/>*/}
            {/*        {item.site}, à partir du {*/}
            {/*        new Date(item.date_arrived.date).toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })*/}
            {/*      }*/}
            {/*      </div>*/}
            {/*  ))}*/}
            {/*</div>*/}
          </div>
        </div>
      </div>
  )
}

export default ClientShow
