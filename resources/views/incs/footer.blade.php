   <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-footer col-md-3 ">
                    <h3>Useful</h3>
                    <ul class="no-list-style footer-navigate-section">
                        <li style="color:white">
                            MSF European Supply Centres
                            <div class="container">
                                <ul>
                                    <li><a href="https://www.msfsupply.be/" target="_blank">MSF Supply Brussels</a></li>
                                    <li><a href="https://www.msflogistique.org/" target="_blank">MSF Logistique Bordeaux</a></li>
                                    <li class="disabled"><a href="https://apps.powerapps.com/play/c91839ea-eb18-4b86-9ef2-0d1bc568a0f1?tenantId=4d9dd1af-83ce-4e9b-b090-b0543ccc2b31" target="_blank">MSF APU Amsterdam Procurement Unit</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="https://unicat.msf.org" target="_blank">MSF catalogue</a></li>
                        <li class="disabled"><a href=""  target="_blank">Executive Supply Chain Committee</a></li>
                        <li class=""><a href="https://www.msf.org/" target="_blank">MSF International</a></li>
                        <li class=""><a href="{{URL('extra_net')}}"  target="_blank">MSF Supply Kenya Extranet</a></li>
                        <li><a href="{{URL('/dwnlds?dwnld=gpc')}}">General Purchasing Conditions</a></li>
                    </ul>
                </div>

                <div class="col-footer col-md-3 ">
                    <h3>Navigate</h3>
                    <ul class="no-list-style footer-navigate-section">
                        <li><a href="{{URL('/')}}">Home</a></li>
                        <li><a href="{{URL('/about')}}">About</a></li>
                        <li><a href="{{URL('/services')}}">Services</a></li>
                        <li><a href="{{URL('/catalogue')}}">Catalogue</a></li>
                        <li><a href="{{URL('/contacts')}}">Contacts</a></li>
                        <li><a href="{{URL('/hr')}}">Careers</a></li>
                    </ul>
                </div>
            
                <div class="col-footer col-md-3 ">
                    <h3>Address</h3>
                    <p class="contact-us-details">
                        MSF Supply Kenya<br>
                        Memkam Complex, Unit 1<br>
                        Road C off enterprise Road, Near Winners Chapel<br/>
                        P.O. Box 38897 – 00623<br/>
                        Nairobi, Kenya<br/>
                        Telephone +254 (0) 20 354 2419
                    </p>
                </div>

                <div class="col-footer col-md-3 ">
                    <h3>Contacts</h3>
                    <p class="contact-us-details">
                        @if (AUTH::guest()) Support @else Customer Service @endif <br>
                        @if (AUTH::guest()) <a href="mailto:Support.MSFSUPPLYKE@brussels.msf.org">Support.MSFSUPPLYKE@brussels.msf.org</a> @else <a href="mailto:CustomerService.MSFSUPPLYKE@brussels.msf.org">CustomerService.MSFSUPPLYKE@brussels.msf.org</a> @endif<br>
                        Telephone @if (AUTH::guest()) +254 (0) 20 354 2419 @else +254 (0) 794 655 262 @endif
                    </p>
                </div>
                
                {{-- <div class="col-footer col-md-6 col-xs-6">
                    <h3>Contacts</h3>
                    <div class="row">
                        <div class="col-footer col-md-6 col-xs-6">
                            <p class="contact-us-details">
                                MSF Kenya Supply Unit<br>
                                Road C off enterprise Road<br>
                                Sameer Industrial Park<br/>
                                P.O. Box 38897 – 00623<br/>
                                Nairobi, Kenya<br/>
                                Telephone +254 (0)20 354 2419
                            </p>
                        </div>
                        <div class="col-footer col-md-6 col-xs-12">
                            <p class="contact-us-details">
                                KSU Customer Service<br>
                                <a href="MSFOCB-KSU-CustomerService@brussels.msf.org">MSFOCB-KSU-CustomerService@brussels.msf.org</a><br>
                                Cell +254 (0)<br>
                                KSU HR Manager<br>
                                <a href="MSFOCB-KSU-Admin@brussels.msf.org">MSFOCB-KSU-Admin@brussels.msf.org</a><br>
                                Cell +254 (0) 705 000 570<br>
                                KSU General Manager<br>
                                <a href="MSFOCB-KSU-Coord@brussels.msf.org">MSFOCB-KSU-Coord@brussels.msf.org</a><br>
                                Cell +254 (0) 722 509 964
                            </p>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                        <div class="footer-copyright">All prices on this web site are subject to change without notice</div>
                    <div class="footer-copyright">&copy; {{now()->year}} MSF-KSU. All rights reserved.</div>
                </div>
            </div>
        </div>
    </div>