<?php 
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccines data</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<nav style=" height:50px;">
    <a href="cases.php">Home</a>
    <a href="cases.php">Cases</a>
    <a href="Deaths.php">Deaths</a>
    <a href="vaccines.php">Vaccines</a>
    <a href="">About</a>
    <a href="">Contact</a>

    <h1 style="  text-align: center;  line-height: 0.8;font-family: Arial, Helvetica, sans-serif; padding-top:25px;">Malaria Vaccinination in Kenya</h1>
<script src="js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">
<div class="row row-cols-1 row-cols-md-3 g-4">
  <div class="col">
    <div class="card">
      <div class="card-body">
      <?php
try {
    // Retrieve data from county_vaccine_data table
    $fetchStmt = $pdo->prepare("SELECT SUM(vaccines_received) AS total_vaccines_received FROM county_vaccine_data");
    $fetchStmt->execute();
    $result = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // Display the sum of vaccines received
    $totalVaccinesReceived = $result['total_vaccines_received'];
    echo $totalVaccinesReceived;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
        <p class="card-text">This is the total number of malaria vaccines received in Kenya.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-body">


        <h5 class="card-title"></h5>
<?php
        try {
    // Received vaccines
    $fetchTotalReceivedStmt = $pdo->prepare("SELECT SUM(vaccines_received) AS total_vaccines_received FROM county_vaccine_data");
    $fetchTotalReceivedStmt->execute();
    $resultTotalReceived = $fetchTotalReceivedStmt->fetch(PDO::FETCH_ASSOC);
    //administered vaccines
    $fetchStmt = $pdo->prepare("SELECT SUM(vaccines_administered) AS total_vaccines_administered FROM county_vaccine_data");
    $fetchStmt->execute();
    $result = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    

    // Display the sum of vaccines received
    $totalVaccinesAdministered = $result['total_vaccines_administered'];
    echo $totalVaccinesAdministered;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
        <p class="card-text">This is the number of administered vaccines.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">vaccines Received in Each County</h5>

        <?php
try {
    // Retrieve data from county_vaccine_data table
    $fetchStmt = $pdo->prepare("SELECT county_name, SUM(vaccines_received) AS total_vaccines_received FROM county_vaccine_data GROUP BY county_name");
    $fetchStmt->execute();
    $result = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        echo '<h2></h2>';
        echo '<table border="1">';
        echo '<tr><th>County Name</th><th>Total Vaccines Received</th></tr>';

        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['county_name'] . '</td>';
            echo '<td>' . $row['total_vaccines_received'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No data found in the county_vaccine_data table.';
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
        <p class="card-text">This is the number of vaccines received in each County.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card" style="width:100%;" >
      <div class="card-body">
        <h1 class="card-title">Types Malaria Vaccines</h1>
        <p class="card-text">
          <h1>Introduction</h1>
          The malaria vaccine RTS,S/AS01E (brand name MosquirixTM) received a favorable opinion from the European Medicines Agency (EMA) in 2015 after review of its safety and efficacy to reduce clinical Plasmodium falciparum malaria episodes in young African children. This was a milestone in vaccine development as the first human parasite vaccine passed the highest level of regulatory scrutiny (referred to as WHO-listed authority maturity level 4 (WLA ML4))1. RTS,S/AS01E pilot implementation programs requested by WHO were launched in 2019 to assess safety and benefits during delivery through standard public health mechanisms. Meanwhile, novel malaria vaccine candidate clinical development has continued apace. Some new vaccine candidates seek to improve on the efficacy of RTS,S/AS01E to prevent clinical malaria in African children, while other candidates in the clinic will pursue different indications such as to protect pregnant women from malaria, or to interrupt the parasite’s cycle of transmission and thereby contribute to regional elimination of malaria by blocking P. falciparum infection or transmission to mosquitoes.
        </p>
        <p>Pre-erythrocytic vaccines
Pre-erythrocytic vaccines (PEV) target antigens from Plasmodium sporozoite and liver stages, the clinically silent forms that initiate human infection after a mosquito inoculates sporozoites into skin. PEV are designed to induce (1) antibodies against surface antigens that clear sporozoites from skin or bloodstream or block their invasion of hepatocytes, or (2) T cell responses that attack infected hepatocytes. Protective efficacy of PEV was first demonstrated in a human in the 1970s using radiation-attenuated WSV delivered through hundreds of mosquito bites; the vaccinee was protected from subsequent challenge with homologous (i.e., identical strain)3 and heterologous4 P. falciparum sporozoites (PfSPZ) but not from challenge with homologous blood-stage parasites3. PEV with high activity can completely clear pre-erythrocytic parasites before release into the bloodstream, and these have also been referred to as anti-infection vaccines (AIV).</p>
<p>RTS, S and CSP-based vaccines
The demonstration that WSV induce sterilizing immunity in humans coincided with the development of genetic engineering tools. The first malaria gene to be cloned encodes the major surface antigen of sporozoites called circumsporozoite protein or CSP5, which continues to be a major focus of vaccine development. RTS,S, the most advanced PEV, incorporates a P. falciparum CSP fragment comprising central repeat (hence “R”) and C-terminal regions (containing T cell epitopes, hence “T”) fused to hepatitis B surface antigen (“S”), or altogether “RTS”. RTS is expressed in yeast that also carry hepatitis B “S” expression cassettes, and thus synthesize S and RTS polypeptides that spontaneously co-assemble into mixed lipoprotein particles (or “RTS,S”) with the CSP fragment on their surface6.</p>
<p>Whole sporozoite vaccines
Despite evidence since the 1970s that WSV confer sterilizing immunity against sporozoite challenge of humans, WSV were not pursued as a product owing to the perception that manufacture of irradiated sporozoites was impractical for a vaccine28. In 2010, the company Sanaria introduced a platform technology that entails harvesting PfSPZ from the salivary glands of aseptic mosquitoes infected by cultured laboratory parasites, followed by purification, vialing, and cryopreservation in liquid nitrogen vapor phase29. PfSPZ are attenuated by different approaches to prepare the vaccine candidate product: radiation attenuation (called PfSPZ Vaccine), chemoattenuation achieved in vivo by concomitant administration of antimalarial drugs (called PfSPZ-CVac for chemoprophylaxis vaccination), or genetic attenuation by deletion of genes required to complete liver-stage development30 (called PfSPZ-GA1 for the first genetically attenuated PfSPZ candidate (NCT03163121))31. PfSPZ Vaccine has required direct venous inoculation to confer sterile immunity against challenge with sporozoites32. The logistical and potential cost challenges to implementing WSV will include (1) liquid nitrogen cold chain, (2) intravenous inoculation, (3) scale-up of manufacture.</p>
<p>Blood-stage vaccines
BSV target the asexual parasite forms that undergo repeated multiplicative cycles in erythrocytes and cause disease and death. Cycle duration varies between malaria parasite species and determines the period between fevers, or periodicity: 1 day for P. knowlesi, 2 days for P. falciparum, P. vivax and P. ovale, and 3 days for P. malariae. At the completion of each cycle, the brood of ~1–2 dozen progeny (called merozoites) egress from host erythrocytes and within seconds each merozoite has invaded a new erythrocyte to initiate another round of multiplication (and a subset of invasive merozoites commit to generate the sexual forms that will infect mosquitoes).

Blood-stage parasites are an attractive target because this is the disease-causing stage of development, and also because passive transfer of IgG purified from semi-immune African adults was shown to clear parasitemia from African children 6 decades ago45,46 and later in Thai adults47. Of note, the studies in Africa included children with malaria who did not receive antimalarial chemotherapy as the standard of care45,46. and hence would not now pass ethical scrutiny. In subsequent studies, immunization with whole parasite preparations rich in merozoites protected monkeys from P. falciparum infection48, focusing attention of vaccine developers on merozoite invasion over the ensuing years.</p>
<p>PfRH5
P. falciparum reticulocyte-binding protein homolog 5 (PfRH5) binds the essential red cell receptor basigin and shows limited polymorphism53, and entered clinical trials using a viral-vectored prime-boost immunogen54. PfRH5 is the first highly conserved merozoite antigen shown to induce broadly neutralizing antibody in preclinical studies55. In monkeys, different combinations of PfRH5 viral-vectored and/or adjuvanted protein immunogens conferred protective immunity that controlled parasitemia after challenge with virulent heterologous parasites56.</p>
<p>AMA1-RON2
Despite its poor efficacy in previous trials, AMA1 is an essential protein for blood-stage parasite growth. The recognition that AMA1 binds to the rhoptry neck protein RON2 at the merozoite-erythrocyte interface to initiate invasion has revived interest in AMA1 as an immunogen in complex with RON2. When complexed with RON2 peptide, AMA1 antigenicity is altered to generate more potent anti-invasion antibodies than monomeric AMA1 antigen62. In monkeys, AMA1-RON2 showed significantly greater protection against heterologous blood-stage challenge versus AMA1 alone, and conferred sterile protection in half the animals62. As with Rh5, AMA1 vaccines may be improved by structural studies of antigen-antibody complexes to determine epitopes to include or exclude in re-designed immunogens. Unlike Rh5, AMA1 displays extensive sequence variation, and therefore future studies will need to assess the number of alleles or chimeric sequences that will be required for AMA1-RON2 to confer broadly effective immunity.

</p>
<p>Novel BSV antigens
The search for novel BSV antigens has also moved beyond merozoite targets. Parasite antigens are exported to the surface of infected erythrocytes where they are accessible to antibody for hours. Among these, the variant surface antigen family PfEMP1 is immunodominant, mediates parasite sequestration and hence virulence of P. falciparum, and is a target of naturally acquired protective antibody63. However its highly polymorphic sequence, large size, and cysteine-rich conformational structure have impeded vaccine development and no trials of PfEMP1-based vaccines have been reported. An exception to this is VAR2CSA, a distinctly structured PfEMP1 family member used by the parasite to sequester in the placenta, as discussed in the next section on placental malaria vaccines (PMV).</p>
<p>Placental malaria vaccines
PMV target chondroitin sulfate A (CSA)-binding parasites that uniquely sequester in the placenta; hence PMV represent a distinct BSV approach. While vaccines such as PEV and BSV candidates that protect the general population may also benefit pregnant women, naturally acquired protection against placental malaria offers a focused vaccine approach. Natural antibodies to CSA-binding parasites are associated with protection from placental malaria and are acquired over successive pregnancies as women in endemic areas become resistant to placental malaria71. Placental parasites uniformly express the distinctive PfEMP1 family member VAR2CSA that binds CSA72; recombinant VAR2CSA induces antibodies that block parasite binding to CSA (reviewed in ref. 73). VAR2CSA is a complex target that has a large (>300 kD) extracellular domain with six DBL domains and additional interdomain regions, and a recent report identified atypical VAR2CSA with seven or eight DBL domains in some field isolates that can be functional74.</p>
<p>Transmission-blocking vaccines
TBV incorporate surface antigens of mosquito/sexual-stages (gametes and zygotes) in order to induce antibodies that kill parasites in the mosquito bloodmeal and interrupt parasite transmission through the vector77,78. Target antigens were identified with monoclonal antibodies that were raised in rodents against gamete/zygote preparations and blocked infection of mosquitoes. The four leading candidates have been grouped as gamete surface proteins first expressed by gametocytes in human blood79 such as Pfs230 and Pfs48/45 of P. falciparum, and zygote surface proteins expressed only post-fertilization in the mosquito host80,81 such as Pfs25 and Pfs28. These antigens are cysteine-rich with multiple 6-cys or epidermal growth factor (EGF)-like domains that have been challenging to prepare as properly folded recombinant protein. Pfs25 was the first TBV candidate prepared as a recombinant protein82. In animal studies, Pfs25 candidates have induced equal or greater serum transmission-blocking activity as other antigens or antigen combinations83,84 and hence Pfs25 has been the focus of clinical trials published to date. Ongoing trials are now examining the activity of Pfs230 vaccine candidates (ClinicalTrials.gov IDs NCT02942277; NCT03917654). Pfs230 antibodies raised in animals show lytic activity against P. falciparum gametes in the presence of complement85, which might similarly enhance activity of human Pfs230 antisera.

</p>
<p>Vivax vaccines
P. vivax causes an estimated 14.3 million malaria episodes each year and is the leading cause of malaria in Asia and Latin America95. Although it has been historically designated as benign tertian malaria, P. vivax is increasingly recognized as a public health threat causing severe morbidity and mortality96. Further, sterile heterologous immunity against P. vivax has been demonstrated4,97. Despite this, P. vivax research suffers from a dearth of resources since the funds dedicated to malaria research—which are not commensurate to the scope of the problem in any case—are predominantly allocated to P. falciparum research. This inadequate investment is particularly short-sighted, since vaccines may disproportionately benefit P. vivax control: dormant liver forms called hypnozoites produced by P. vivax (but not by P. falciparum) allow the parasite to relapse repeatedly over months or years and thwart efforts to control or eliminate this species, hence the benefit of durable immunological protection conferred by vaccines.

</p>

<p>References
WHO. (World Health Organization, Geneva, Switzerland, 2017).

The mal, E. R. A. C. G. O. V. A research agenda for malaria eradication: vaccines. PLOS Med. 8, e1000398 (2011).

Google Scholar
 

Clyde, D. F., Most, H., McCarthy, V. C. & Vanderberg, J. P. Immunization of man against sporozite-induced falciparum malaria. Am. J. Med. Sci. 266, 169–177 (1973).

CAS
 
PubMed
 
Google Scholar
 

Clyde, D. F. Immunization of man against falciparum and vivax malaria by use of attenuated sporozoites. Am. J. Trop. Med. Hyg. 24, 397–401 (1975).</p>
      </div>
    </div>
  </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>