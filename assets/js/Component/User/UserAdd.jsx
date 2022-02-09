import React, {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate, useParams} from "react-router-dom";

function UserAdd(props) {

  let userId = useParams();
  const initialUser = {
    firstname: '',
    lastname: '',
    password: '',
    email: '',
    role: '',
    site: ''
  }
  const [roles, setRoles] = useState([])
  const [sites, setSites] = useState([])
  const [isLoading, setIsLoading] = useState(true);
  const [edit, setEdit] = useState(false);
  const history = useNavigate()
  const [user, setUser] = useState(initialUser);

  function getUser() {
    axios.get('/api/user/show/' + userId.userId).then((userShow) => {
      console.log('user data', userShow.data)
      setUser(userShow.data)
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

  const handleChange = (event) => {
    setUser({...user, [event.target.name]: event.target.value});
  }

  useEffect(() => {
    getRolesList();
    getSiteIndex();
    getUser();
  }, [])

  function getRolesList() {
    axios.get('/api/user/roles_list').then((response) => {
      console.log('roles data', response)
      response.data.map(item => console.log('role',item))
      setRoles(response.data);
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

  function getSiteIndex() {
    axios.get('/api/site/index').then((response) => {
      console.log('sites data', response)
      setSites(response.data);
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

  const handleSubmit = event => {
    event.preventDefault();
    console.log(user)
    axios.post('/api/user/add', user
    ).then((response) => {
      console.log('user data', response);
      faireRedirection();
    }).catch(error => {
      console.log('error', error)
    })
  }
  let url = "/users"

  const faireRedirection = () =>{
        history(url)
  }

  if (isLoading) return 'loading !! ';
  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>Ajout d'un utilisateur</h1>
          </div>
        </div>
        <hr/>
        <div>
          <form onSubmit={handleSubmit}>
            <div className={'mb-3'}>
              <div className={'row'}>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="fisrtname">Prénom</label>
                  <input className={'form-control'} type="text" name={'firstname'} onChange={handleChange}/>
                </div>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="lastname">Nom</label>
                  <input className={'form-control'} type="text" name={'lastname'} onChange={handleChange}/>
                </div>
              </div>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="password">Mot de passe</label>
              <input className={'form-control form-check'} type="password" name={'password'} onChange={handleChange}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="email">Email</label>
              <input className={'form-control form-check'} type="email" name={'email'} onChange={handleChange}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="role">Droit</label>
              <select className={'form-control'} name="role" onChange={handleChange}>
                <option value="">Selectionner un rôle</option>
                {
                  roles.map(role => <option key={role.id} value={role.id}>{role.name}</option>)
                }
              </select>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="site">Chantier</label>
              <select className={'form-control'} name="site" onChange={handleChange}>
                <option value="">Selectionner un chantier</option>
                {
                  sites.map(site => <option key={site.id} value={site.id}>{site.name}</option>)
                }
              </select>
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
