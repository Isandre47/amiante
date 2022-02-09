import React, {useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import axios from "axios";

function UserShow() {

  let user = useParams();
  const [userInfo, setUserInfo] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    getUser();
  }, [])

  function getUser() {
    axios.get('/api/user/show/'+user.userId).then((userShow) => {
      console.log('user data', userShow.data)
      // userShow.data.site.zones.map(item => item.initials.map(value => console.log('inistals',value)))
      setUserInfo(userShow.data);
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
  if (isLoading) return 'loading !! ';
  return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{height: '10vh'}}>
            <div className="col-12 text-center">
              <h1>Salut {userInfo.firstname} {userInfo.lastname} !</h1>
            </div>
          </div>
          <hr/>
          <div className={'container'}>
            <div className={'row'}>
              <div className={'col-6'}>
                <h3>{userInfo.site.name}</h3>
                <br/>
                {
                  userInfo.site.zones.map((zone) => (
                          <div key={zone.id}>
                            <h4 key={zone.category.id}>Phase: {zone.category.name}</h4>
                            <span className={'font-weight-bold'}>Analyse initiale:</span>
                            <br/>
                            {zone.initials.map((init) => (
                                    <div key={init.id}>{init.location} <br/></div>
                                )
                            )}
                            <span className={'font-weight-bold'}>Analyse en cours:</span>
                            <br/>
                            {zone.removals.map((removal) => (
                                    <div key={removal.id}>{removal.location}<br/></div>
                                )
                            )}
                            <span className={'font-weight-bold'}>Analyse de fin:</span>
                            <br/>
                            {zone.outputs.map((output) => (
                                    <div key={output.id}>{output.location} <br/></div>
                                )
                            )}
                            <hr/>
                          </div>
                      )
                  )
                }
              </div>
              <div className={'col-4'}>
                Historique : <br/>
                {userInfo.history.map((item) => (
                    // console.log('date', new Date(item.date_arrived.date).toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }))
                    <div>
                      Nombre de chantiers: {userInfo.length} <br/>
                      {item.site}, à partir du {
                          new Date(item.date_arrived.date).toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
                    }
                    </div>
                ))}
              </div>
            </div>
          </div>
        </div>
    )
}

export default UserShow
