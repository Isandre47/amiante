import React, {Component} from "react";
import {BrowserRouter, Link, Route, Routes} from "react-router-dom";
import Logo from '/public/images/logo_dragon.png';

function Navbar() {
    return (
        <div className={'col-2 bg-light'}>
          <div>
            <Link to={'/dashboard'}>
              <img className="img-fluid" src={Logo} alt="logo" />
            </Link>
          </div>
          <nav className={'navbar'}>
            <ul className={'navbar-nav'}>
              <li className={'list-unstyled'}>
                <Link to={'/users'} className={'nav-link'}>Gestion utilisateur</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/clients'} className={'nav-link'}>Gestion client</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/chantiers'} className={'nav-link'}>Gestion chantier</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/materiels'} className={'nav-link'}>Gestion matériel</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/categories'} className={'nav-link'}>Gestion catégories</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/analyse-initiale'} className={'nav-link'}>Gestion analyse initiale</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/analyse-retrait'} className={'nav-link'}>Gestion analyse en cours de retrait</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/analyse-repli'} className={'nav-link'}>Gestion analyse avant et après repli</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/processus'} className={'nav-link'}>Gestion des processus</Link>
              </li>
              <li className={'list-unstyled'}>
                <Link to={'/masques'} className={'nav-link'}>Gestion des masques</Link>
              </li>
            </ul>
          </nav>
        </div>
    )
}

export default Navbar
