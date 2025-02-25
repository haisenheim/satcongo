@extends('Layouts.app')
@section('top')
<div class="d-flex gap-3">
    <div>
        <span>Connecté  en tant que :</span>
        <strong><span class="badge bg-white text-dark fs-6">Opérateur de dossiers</span></strong>
    </div>
</div>
@endsection
@section('navigation')
 <!-- Navigation Category -->
 <?php
    $active = \Illuminate\Support\Facades\Session::get('active');
?>
     <!-- Navigation Category -->
     <div class="mainnav__categoriy py-3">
        <h6 class="mainnav__caption mt-0 px-3 fw-bold">Navigation</h6>
        <ul class="mainnav__menu nav flex-column">
           <li class="nav-item">
               <a href="{{ route('operateur.dashboard') }}" class="nav-link mininav-toggle {{ $active==1?'active':'' }}"><i class="demo-pli-home fs-3 me-2"></i>
                   <span class="nav-label mininav-content ms-1">Accueil</span>
               </a>
           </li>
           <li class="nav-item">
                <a href="{{ route('operateur.dossiers.index') }}" class="nav-link mininav-toggle {{ $active==2?'active':'' }}"><i class="pli-folders fs-3 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Dossiers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('operateur.clients.index') }}" class="nav-link mininav-toggle {{ $active==3?'active':'' }}"><i class="pli-conference fs-3 me-2"></i>
                    <span class="nav-label mininav-content ms-1">Clients</span>
                </a>
            </li>




        </ul>
    </div>
    <!-- END : Navigation Category -->
@endsection
