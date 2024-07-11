<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\ViewInterface;

return function(array $data = []){

    if (!isset($data[ViewInterface::FOOTER_DATA])) {
        return '';
    }
    
    $footerData = $data[ViewInterface::FOOTER_DATA];

    $copyrights = $footerData['copyrights'];

    return <<<FOOTER
        <footer class="bg-light mb-3">
                <div class="row">
                    <div class="col-sm-4 p-5">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius deserunt eaque ipsam voluptate hic libero earum, temporibus accusamus dicta error, dolores repudiandae quaerat itaque iure odio dignissimos odit, distinctio obcaecati?
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
                    <div class="col">
                        {$copyrights}
                    </div>
                </div>
        </footer>
    FOOTER;
};