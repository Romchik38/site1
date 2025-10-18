<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;

return function(array $data = []){

    if (!isset($data[HttpViewInterface::FOOTER_DATA])) {
        return '';
    }
    
    /** @var FooterDTOInterface $footerData */
    $footerData = $data[HttpViewInterface::FOOTER_DATA];

    $copyrights = htmlentities($footerData->getCopyrightsText());

    return <<<FOOTER
        <footer class="text-dark mb-3" style="background-color:rgba(13, 110, 253, 0.34)">
                <div class="row">
                    <div class="col-sm-4 p-5">
                        <p>Site1 is an example of a simple multi-page website with a login system and a sitemap. The code for this website is available for free on <a href="https://github.com/Romchik38/site1" target="_blank">GitHub</a>. You can review it and download it for your personal needs. Please read the <a href="https://github.com/Romchik38/site1/blob/main/LICENSE.md" target="_blank">license</a> before use.</p>
                        <p>If you need a more functional website, with multiple languages, a blog, and an administrative part, visit <a href="https://site2.romanenko-studio.dev/en/about-this-site" target="_blank">Site2 (Lawshield)</a>.</p>
                    </div>
                    <div class="col-sm-4 p-5">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="fw-bold">Links</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="/sitemap">Sitemap</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">About</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Contacts</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Shop</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Themes</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Blog</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Privacy Notice</a></li>
                                  </ul>
                            </div>
                            <div class="col-6">
                                <h5 class="fw-bold">Customer</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Log In</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Register</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Terms & Conditions</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Rules</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Order</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Support</a></li>
                                  </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 p-5">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="fw-bold">Links</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Home</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">About</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Contacts</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Shop</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Themes</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Blog</a></li>
                                    <li class="mb-2"><a class="link-dark text-decoration-none" href="#">Privacy Notice</a></li>
                                  </ul>
                            </div>
                            <div class="col-sm-6">
                                <h5>Subscribe us</h5>
                                <form action="">
                                    <label class="form-label" for="email">News and sales</label>
                                    <input class="form-control" type="email" required>
                                    <button class="btn btn-secondary my-3">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row copyrights text-center">
                    <div class="col  mb-3">
                        © 2024-2025, <a href="https://romanenko-studio.dev/" target="_blank">Romanenko Studio</a>, all rights reserved
                    </div>
                </div>
        </footer>
    FOOTER;
};