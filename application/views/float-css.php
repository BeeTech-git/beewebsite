
    <style>
        .floating-buttons{
            position:fixed;
            right:0;
            top:50%;
            transform:translateY(-50%);
            z-index:9999;
        }

        /* Common */
        .float-btn{
            position:absolute;
            right:-125px;          /* Hide text */
            width:180px;
            height:55px;

            display:flex;
            align-items:center;

            border-radius:30px 0 0 30px;
            color:#000;
            text-decoration:none;

            transition:right .3s ease;
            box-sizing:border-box;
        }

        .float-btn:hover{
            right:0;
        }

        /* Position each button */
        .flw{ top:0; }
        .flc{ top:70px; }
        .fld{ top:140px; }

        .float-btn i{
            width:55px;
            text-align:center;
            font-size:22px;
            flex-shrink:0;
        }

        .float-btn span{
            white-space:nowrap;
        }

        /* Colors */

        .whatsapp{
            background:#ffffff;
        }

        .call{
            background:#ffffff;
        }

        .demo{
            background:#ffffff;
        }
    </style>