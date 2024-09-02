# Todo

[-] escape input data  
[-] namespaces in the templates  
[-] add img to login page  
[-] change logo
[-] add favicon
[-] sitemap 'root' to interface  

## escape input data  

[+] Layouts  
  [+] Login recovery  
  [+] Main
[+] Tamplates
[-] js username

### js

```javascript
function escapeHTML(str) {
  return str.replace(/&/g, '&amp;’)
    .replace(/</g, '&lt;’)
    .replace(/>/g, '&gt;’)
    .replace(/"/g, '&quot;’)
    .replace(/’/g, '&#039;’);
}
```
