import React, {Component} from "react";
import axios from "axios";
import {Link, Route, Routes} from "react-router-dom";
import UserShow from "./UserShow";

class UserIndex extends Component {
  constructor() {
    super();
    this.state = {
      users: [],
    }
  }

  componentDidMount() {
    this.getUsers();
  }

  getUsers() {
    axios.get('/users_page').then(users => {
      console.log('page user', users.data)
      this.setState({users: users.data.users})
    })
  }

  render() {
    return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{height: '4rem'}}>
            <div className={'col-12 text-center'}>
              <h1>Index des utilisateurs !</h1>
            </div>
          </div>
          <hr/>
          <a href="#">Ajouter un utilisateur</a>
          <div className={'row m-3'}>
            <table className={'table table-striped table-hover'}>
              <thead>
              <tr>
                <td>email</td>
                <td>Nom prénom</td>
                <td>Chantier actuel</td>
                <td>Gestion</td>
              </tr>
              </thead>
              <tbody>
              {
                this.state.users.map(user =>
                    <tr key={user.id}>
                      <td>{user.email}</td>
                      <td>{user.lastname} {user.firstname}</td>
                      <td className={user.site === null ? 'bg-primary': ''}>
                        {user.site === null ? <span>gère des chantiers</span> : user.site.name}<
                      /td>
                      <td>
                        <a href="#">Editer</a>
                        -
                        <Link to={`/users/${user.id}`} className={'nav-link'} key={user.id}> Plus d'infos {user.id}</Link>
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
}

export default UserIndex
