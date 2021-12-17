import React, {Component} from "react";

class Navbar extends Component {

  render() {
    return (
        <div className={'navbar'}>
          <a href="/homepage">Lien admin général</a>
          <ul className={'navbar-nav'}>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="/users">Gestion utilisateur</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion client</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion chantier</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion matériel</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion catégories</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion analyse initiale</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion analyse en cours</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion analyse avant et après</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion des processus</a>
            </li>
            <li className={'nav-item'}>
              <a className={'nav-link'} href="#">Gestion des masques</a>
            </li>
          </ul>
        </div>
    )
  }
}

export default Navbar
