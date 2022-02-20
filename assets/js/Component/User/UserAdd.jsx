import React, {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate, useParams} from "react-router-dom";

function UserAdd() {

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
  const [title, setTitle] = useState('Chargement en cours');
  const history = useNavigate()
  const [userInfo, setUserInfo] = useState(initialUser);

  const handleChange = (event) => {
    setUserInfo({...userInfo, [event.target.name]: event.target.value});
    console.log('user change', userInfo)
  }

  useEffect(() => {
    getRolesList();
    getSiteIndex();
  }, [])

  useEffect(() => {
    if (userId.userId === undefined) {
      console.log('aucun user');
      setTitle('Ajout d\'un utilisateur')
      setIsLoading(false);
    } else {
      axios.get('/api/user/show/' + userId.userId).then(response => {
        setUserInfo({...userInfo,
          firstname: response.data.firstname,
          lastname: response.data.lastname,
          password: response.data.password,
          email: response.data.email,
          role: response.data.roles[0],
          site: response.data.site.id
        })
        console.log(response.data, response.data.roles[0], response.data.site.name)
        setEdit(true);
        setTitle('Edition d\'un utilisateur')
        setIsLoading(false);
      })
      console.log('res', userInfo)
    }
  }, [])


  function getRolesList() {
    axios.get('/api/user/roles_list').then((response) => {
      console.log('roles data', response)
      response.data.map(item => console.log('role',item))
      setRoles(response.data);
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
    console.log(userInfo)
    if (edit) {
      console.log('edition')
      axios.post('/api/user/edit/'+ userId.userId, userInfo
      ).then((response) => {
        console.log('user data', response);
        faireRedirection();
      }).catch(error => {
        console.log('error', error)
      })
    } else {
      axios.post('/api/user/add', userInfo
      ).then((response) => {
        console.log('user data', response);
        faireRedirection();
      }).catch(error => {
        console.log('error', error)
      })
    }
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
                  <input className={'form-control'} type="text" name={'firstname'} onChange={handleChange} value={userInfo.firstname}/>
                </div>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="lastname">Nom</label>
                  <input className={'form-control'} type="text" name={'lastname'} onChange={handleChange} value={userInfo.lastname}/>
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
              <input className={'form-control form-check'} type="email" name={'email'} onChange={handleChange} value={userInfo.email}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="role">Droit</label>
              <select className={'form-control'} name="role" onChange={handleChange} value={userInfo.role}>
                <option value="">Selectionner un rôle</option>
                {
                  roles.map(role => <option key={role.id} value={role.id}>{role.name}</option>)
                }
              </select>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="site">Chantier</label>
              <select className={'form-control'} name="site" onChange={handleChange} value={userInfo.site}>
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
