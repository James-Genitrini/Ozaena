@extends('layouts.app')

@section('title', 'Conditions Générales de Vente')

@push('styles')
    <style>
        main {
            max-width: 850px;
            margin: 3rem auto;
            padding: 2rem 2.5rem;
            background-color: #1a1a1a;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            line-height: 1.8;
            color: #eee;
            font-family: 'Inter', sans-serif;
        }

        h1 {
            font-weight: 800;
            font-size: 2.4rem;
            margin-bottom: 2rem;
            text-align: center;
            color: #fff;
        }

        h2 {
            font-weight: 700;
            font-size: 1.6rem;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: #f0f0f0;
            border-left: 4px solid #0a84ff;
            padding-left: 0.75rem;
        }

        p {
            font-size: 1.05rem;
            color: #ddd;
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        a {
            color: #0a84ff;
            text-decoration: underline;
            transition: color 0.2s;
        }

        a:hover {
            color: #0080ff;
            text-decoration: none;
        }

        ul,
        ol {
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
        }

        li {
            margin-bottom: 0.8rem;
        }

        @media(max-width: 768px) {
            main {
                padding: 1.5rem 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.4rem;
            }
        }
    </style>
@endpush

@section('content')
    <h1>Conditions Générales de Vente (CGV)</h1>

    <h2>Article 1. Caractéristiques essentielles des produits vendus</h2>
    <p>Les produits vendus sur ce site correspondent à des textiles prêt-à-porter de mode “streetwear”.
        Y seront proposés à la vente, des maillots de football et plus généralement des articles à destination sportive.</p>

    <h2>Article 2. Prix de vente</h2>
    <p>Les prix des produits vendus par nos soins présents sur le site se situent dans une fourchette
        entre <em>55</em> et <em>110</em> €. En cas de réduction ou d’offre exclusive de notre
        part,
        les changements de prix des articles concernés seront indiqués sur l’interface même du présent site internet.
        Les prix sont indiqués en EUROS (€).</p>

    <h2>Article 3. Paiement</h2>
    <p>Le paiement est dû lors de la validation de votre panier et votre consentement donné pour procéder à l’étape suivante
        constitutive dudit paiement.</p>

    <h3>Article 3.1. Modalité de paiement</h3>
    <p>Le paiement de votre commande s’effectuera à travers le site internet à l’aide de votre carte bancaire.
        Ce mode de paiement est le seul admissible à travers notre site.
        Un e-mail de confirmation de réception de votre commande par nos soins vous sera envoyé par la suite afin d’en
        certifier la teneur.</p>

    <h3>Article 3.2. Retard de paiement</h3>
    <p>En cas de solde insuffisant, le paiement ne pourra avoir lieu, ce qui annulera la commande.
        Néanmoins, si la commande est acceptée malgré un solde insuffisant, une notification vous sera adressée afin de
        régler le reste dû,
        majoré d’intérêts moratoires à taux légal (7,21% pour un consommateur non professionnel).
        Pour un consommateur professionnel, le taux applicable est celui de la BCE majoré de 10 points, calculé par jour
        jusqu’au paiement intégral.</p>

    <h2>Article 4. Livraison de votre commande</h2>
    <p>La livraison sera assurée par un prestataire externe. Elle portera un coût supplémentaire variant selon l’adresse de
        livraison.
        En cas de commande comportant deux articles ou plus, les frais de livraison vous seront offerts.</p>
    <p>Le délai de livraison est susceptible de varier en fonction de l’adresse de livraison souhaitée.</p>

    <h2>Article 5. Délai de rétractation</h2>
    <p>Conformément à l’article L221-18 du code de la consommation, vous disposez d’un délai de 14 jours pour annuler votre
        commande.
        Il vous suffira de remplir le formulaire prévu à cet effet sur le site.</p>
    <p>En cas de rétractation, les frais de retour sont à la charge du consommateur, sauf si le vendeur choisit de les
        prendre en charge.
        Le consommateur dispose également de 14 jours pour renvoyer le bien.</p>

    <h3>Article 5.1. Conditions de remboursement</h3>
    <p>En cas de rétractation et retour du produit, la société <em>Ozaena</em> procèdera au remboursement sous 14
        jours maximum,
        après réception du bien ou preuve de son renvoi.
        Le remboursement se fera par virement bancaire sur communication du RIB du consommateur.</p>

    <h2>Article 6. Responsabilité du bien</h2>
    <p>La responsabilité du bien incombe au vendeur jusqu’à l’envoi.
        Elle est ensuite transférée au transporteur, puis au consommateur lors de la livraison.</p>

    <h2>Article 7. Service après-vente (SAV)</h2>
    <p>Un service après-vente est assuré par la société <em>Ozaena</em>.
        Contact par mail : <em>contact.ozaena@gmail.com</em> pour toute demande (produit, rétractation, remboursement…).</p>

    <h2>Article 8. Coordonnées de la société</h2>
    <p><em>SIRET : 990 958 506 00018<br>
    Adresse : 519 A LES COREAUX, 68910 LABAROCHE<br>
    Email : <a href="mailto:contact@ozæna.com">contact@ozæna.com</a><br>
    Téléphone : +33 6 66 63 68 44</em></p>

    <h2>Article 9. Recours à une résolution amiable</h2>
    <p>En cas de litige, le recours à une médiation ou conciliation de justice est obligatoire depuis le 1er octobre 2023.
        La société <em>Ozaena</em> s’engage à saisir une personnalité judiciaire compétente.</p>

    <h2>Article 10. Numéro RCS</h2>
    <p><em>990 958 506 00018</em></p>

    <h2>Article 11. Tribunal compétent</h2>
    <p>Si aucun accord amiable n’est trouvé, le tribunal judiciaire sera compétent pour trancher le litige entre vendeur
        professionnel et consommateur.</p>

    {{-- <h2>Article 12. Police d’assurance</h2>
    <p>La société <em>Ozaena</em> a souscrit une assurance civile professionnelle auprès de <em>(insérer
            compagnie)</em>,
        couvrant <em>(insérer couverture prévue)</em>.</p> --}}
@endsection