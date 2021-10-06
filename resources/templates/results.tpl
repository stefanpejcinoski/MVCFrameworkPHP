<html>
<head>
<title>{$appname}-Results</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">{$appname}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
    </div>
  </div>
</nav>
<div class="container">
{if !(auth())}
  <h3>Please log in</h3>
  {viewString('loginform')}
{else}
  {if isset($results)}
  <div class="row">
    <div class="col">
      {if isset($results['counts'])}
        <ul>
          {foreach from=$results['counts'] item=count key=key}
            <li>{$key}({$count['count']})</li>
            {if isset($count['children'])}
              <li><ul>
                {foreach from=$count['children'] item=childrencount key=childkey}
                  <li>{$childkey}({$childrencount['count']})</li>
                    {if isset($childrencount['children'])}
                      <li><ul>
                      {foreach from=$childrencount['children'] item=grandchildrencount key=grandchildkey}
                        <li>{$grandchildkey}({$grandchildrencount['count']})</li>
                      {/foreach}
                      </ul></li>  
                    {/if}
                 {/foreach}
               </ul></li>
             {/if}
           {/foreach}
         </ul></li>
       {/if}
     </div>
    <div class="col">
      <ul>
        {foreach from=$results['users'] item=user}
          <li>"User: {$user['username']} email: {$user['email']}</li>
        {/foreach}
      </ul>
    </div>
  </div>
  {/if}
{/if}
</div>
</body>
</html>