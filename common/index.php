<FilesMatch "\/page\/">
        Order Deny,Allow
        Allow from env=link_allow
        Deny from all
    </FilesMatch>