import React, {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate, useParams} from "react-router-dom";

function UserAdd() {

  let clientId = useParams();
  const initialClient = {
    firstname: '',
    lastname: '',
    password: '',
    email: '',
    name: ''
  }
  const [isLoading, setIsLoading] = useState(true);
  const [edit, setEdit] = useState(false);
  const [title, setTitle] = useState('Chargement en cours');
  const history = useNavigate()
  const [clientInfo, setClientInfo] = useState(initialClient);

  const handleChange = (event) => {
    setClientInfo({...clientInfo, [event.target.name]: event.target.value});
    console.log('client change', clientInfo)
  }

  useEffect(() => {
    if (clientId.clientId === undefined) {
      console.log('aucun user');
      setTitle('Ajout d\'un client')
      setIsLoading(false);
    } else {
      axios.get('/api/client/show/' + clientId.clientId).then(response => {
        setClientInfo({...clientInfo,
          firstname: response.data.firstname,
          lastname: response.data.lastname,
          password: response.data.password,
          email: response.data.email,
          role: response.data.roles[0],
          site: response.data.site.id
        })
        console.log(response.data, response.data.roles[0], response.data.site.name)
        setEdit(true);
        setTitle('Edition d\'un client')
        setIsLoading(false);
      })
      console.log('res', clientInfo)
    }
  }, [])

  const handleSubmit = event => {
    event.preventDefault();
    console.log(clientInfo)
    if (edit) {
      console.log('edition')
      axios.post('/api/client/edit/'+ clientId.clientId, clientInfo
      ).then((response) => {
        console.log('client data', response);
        faireRedirection();
      }).catch(error => {
        console.log('error', error)
      })
    } else {
      axios.post('/api/client/add', clientInfo
      ).then((response) => {
        console.log('client data', response);
        faireRedirection();
      }).catch(error => {
        console.log('error', error)
      })
    }
  }
  let url = "/clients"

  const faireRedirection = () =>{
    history(url)
  }

  if (isLoading) return 'loading !! ';
  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>{title}</h1>
          </div>
        </div>
        <hr/>
        <div>
          <form onSubmit={handleSubmit}>
            <div className={'mb-3'}>
              <div className={'row'}>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="fisrtname">Prénom</label>
                  <input className={'form-control'} type="text" name={'firstname'} onChange={handleChange} value={clientInfo.firstname}/>
                </div>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="lastname">Nom</label>
                  <input className={'form-control'} type="text" name={'lastname'} onChange={handleChange} value={clientInfo.lastname}/>
                </div>
              </div>
            </div>
            {!edit ?
                <div className={'mb-3'}>
                  <label className={'form-label'} htmlFor="password">Mot de passe</label>
                  <input className={'form-control form-check'} type="password" name={'password'} onChange={handleChange}/>
                </div>
                : ''
            }

            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="email">Email</label>
              <input className={'form-control form-check'} type="email" name={'email'} onChange={handleChange} value={clientInfo.email}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="name">Nom de la société</label>
              <input className={'form-control form-check'} type="text" name={'name'} onChange={handleChange} value={clientInfo.name}/>
            </div>
            <div className={'mb-3 text-center'}>
              <input className={'btn btn-primary m-auto col-4'} type="submit" value={'Envoyer'}/>
            </div>
          </form>
        </div>
      </div>
  )
}

export default UserAdd
