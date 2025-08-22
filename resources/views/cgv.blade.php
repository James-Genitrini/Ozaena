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

    <p>Les présentes conditions générales de vente s'appliquent à toutes les ventes conclues via le site Ozæna. En validant
        une commande, le client reconnaît avoir lu et accepté les CGV dans leur intégralité.</p>

    <h2>1. Caractéristiques essentielles des produits</h2>
    <p>Les produits proposés sont décrits avec la plus grande exactitude possible (désignation, taille, composition,
        visuels, etc.). Le client est invité à lire attentivement ces caractéristiques avant achat.</p>

    <h2>2. Prix</h2>
    <p>Les prix sont indiqués en euros TTC (toutes taxes comprises) et hors frais de livraison. Les frais de port sont
        précisés avant validation de la commande. Ozæna se réserve le droit de modifier ses prix à tout moment sans préavis.
    </p>

    <h2>3. Commande</h2>
    <p>Le client passe commande en ligne via le site. L’acceptation définitive intervient après validation du paiement.
        Ozæna se réserve le droit de refuser une commande en cas de litige antérieur.</p>

    <h2>4. Paiement</h2>
    <p>Le paiement s’effectue en ligne via une solution sécurisée (ex: Stripe, PayPal). Les moyens de paiement acceptés sont
        : carte bancaire, etc. En cas de retard de paiement, la commande ne sera pas expédiée.</p>

    <h2>5. Livraison</h2>
    <p>Les produits sont livrés en France métropolitaine (et autres zones précisées sur le site). Les délais de livraison
        sont indiqués lors de la commande à titre indicatif. Les frais de livraison sont à la charge du client et affichés
        avant validation.</p>

    <h2>6. Exécution du contrat</h2>
    <p>Le contrat est réputé conclu à réception du paiement. Ozæna s’engage à livrer les produits dans les délais annoncés,
        sauf cas de force majeure.</p>

    <h2>7. Droit de rétractation</h2>
    <p>Conformément aux articles L221-18 et suivants du Code de la consommation, le client dispose d’un délai de 14 jours
        pour exercer son droit de rétractation, sans justification ni frais, à l’exception des frais de retour.</p>
    <p>Le produit doit être retourné dans son état d’origine. Pour exercer ce droit, envoyez un mail à <a
            href="mailto:contact@ozæna.com">contact@ozæna.com</a>.</p>

    <h2>8. Garanties légales</h2>
    <p>Les produits bénéficient de la garantie légale de conformité (articles L217-4 et suivants du Code de la consommation)
        et de la garantie contre les vices cachés (articles 1641 et suivants du Code civil).</p>

    <h2>9. Garantie commerciale / SAV</h2>
    <p>Si une garantie commerciale est proposée, ses conditions seront précisées sur la fiche produit. Le coût de la
        communication à distance (email, téléphone) est au tarif normal sans surtaxe.</p>

    <h2>10. Durée du contrat et résiliation</h2>
    <p>Il n’existe pas de contrat à durée indéterminée. Chaque commande est ponctuelle et conclue pour la durée nécessaire à
        l'exécution et la livraison de la commande.</p>

    <h2>11. Caution / Garantie</h2>
    <p>Aucune caution ou garantie financière n’est exigée du client pour finaliser une commande.</p>

    <h2>12. Obligations minimales du client</h2>
    <p>Le client s’engage à fournir des informations exactes lors de la commande et à procéder au paiement intégral du
        montant dû.</p>

    <h2>13. Code de conduite</h2>
    <p>Ozæna n’adhère à aucun code de conduite spécifique.</p>

    <h2>14. Litiges et médiation</h2>
    <p>En cas de litige, le client peut d’abord adresser une réclamation à Ozæna. À défaut d’accord amiable, le litige peut
        être porté devant le tribunal compétent du lieu du domicile du client.</p>
    <p>Le client peut également recourir à un médiateur de la consommation via <a href="https://ec.europa.eu/consumers/odr"
            target="_blank">la plateforme européenne de règlement des litiges en ligne (RLL)</a>.</p>

    <p>Pour toute question, contactez-nous à <a href="mailto:contact@ozæna.com">contact@ozæna.com</a>.</p>
@endsection