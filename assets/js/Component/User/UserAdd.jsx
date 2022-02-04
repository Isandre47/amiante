import React, {useEffect} from "react";
import axios from "axios";

function UserAdd() {
  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>Ajout d'un utilisateur</h1>
          </div>
        </div>
        <hr/>
        <div>
          <form>
            <div className={'mb-3'}>
              <div className={'row'}>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="prenom">Prénom</label>
                  <input className={'form-control'} type="text" id={'prenom'}/>
                </div>
                <div className={'col-6'}>
                  <label className={'form-label'} htmlFor="nom">Nom</label>
                  <input className={'form-control'} type="text" id={'nom'}/>
                </div>
              </div>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="password">Mot de passe</label>
              <input className={'form-control form-check'} type="password" id={'password'}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="email">Email</label>
              <input className={'form-control form-check'} type="email" id={'email'}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="role">Droit</label>
              <input className={'form-control form-check'} type='text' id={'role'}/>
            </div>
            <div className={'mb-3'}>
              <label className={'form-label'} htmlFor="chantier">Chantier</label>
              <input className={'form-control form-check'} type="text" id={'chantier'}/>
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
