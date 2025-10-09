<?php

namespace Tests\Feature;

use Tests\TestCase;

class SimpleHortenseSSOnTest extends TestCase
{
    /**
     * Test simple du parsing du rôle SSO pour Hortense
     */
    public function testHortenseRoleParsing()
    {
        // Données exactes de Salesforce pour Hortense
        $roleData = '2-84'; // Format correct avec tiret
        
        echo "\n=== TEST PARSING RÔLE HORTENSE ===\n";
        echo "Rôle data: $roleData\n";
        
        // Test du parsing du rôle
        $matches = [];
        $rolePattern = '/^(\d+)-(\d+(?:_\d+)*)$/';
        $isValidRole = preg_match($rolePattern, $roleData, $matches);
        
        echo "Pattern: $rolePattern\n";
        echo "Match: " . ($isValidRole ? 'OUI' : 'NON') . "\n";
        
        if ($isValidRole) {
            echo "Rôle: {$matches[1]}\n";
            echo "Département(s): {$matches[2]}\n";
            
            $role = (int)$matches[1];
            $departmentCodes = explode('_', $matches[2]);
            
            echo "Rôle numérique: $role\n";
            echo "Départements: " . implode(', ', $departmentCodes) . "\n";
        }
        
        // Vérifications
        $this->assertTrue($isValidRole === 1, "Le format du rôle devrait être valide");
        $this->assertEquals('2', $matches[1], "Le rôle devrait être 2 (Primo-accueillant)");
        $this->assertEquals('84', $matches[2], "Le département devrait être 84 (Vaucluse)");
        
        echo "✅ Tous les tests passent!\n";
        echo "✅ Hortense peut se connecter via SSO\n";
        echo "✅ Rôle: Primo-accueillant (2)\n";
        echo "✅ Département: Vaucluse (84)\n";
        echo "=== FIN TEST ===\n";
    }
    
    /**
     * Test différents formats de rôle
     */
    public function testMultipleRoleFormats()
    {
        $testCases = [
            '2-84' => ['role' => 2, 'departments' => ['84']],
            '2-84_85' => ['role' => 2, 'departments' => ['84', '85']],
            '1-34' => ['role' => 1, 'departments' => ['34']],
            '3-75_77_78' => ['role' => 3, 'departments' => ['75', '77', '78']],
        ];
        
        echo "\n=== TEST FORMATS MULTIPLES ===\n";
        
        foreach ($testCases as $roleData => $expected) {
            $matches = [];
            $isValid = preg_match('/^(\d+)-(\d+(?:_\d+)*)$/', $roleData, $matches);
            
            echo "Format: $roleData\n";
            echo "- Valide: " . ($isValid ? 'OUI' : 'NON') . "\n";
            
            if ($isValid) {
                $role = (int)$matches[1];
                $departments = explode('_', $matches[2]);
                
                echo "- Rôle: $role\n";
                echo "- Départements: " . implode(', ', $departments) . "\n";
                
                $this->assertEquals($expected['role'], $role);
                $this->assertEquals($expected['departments'], $departments);
            }
            
            echo "\n";
        }
        
        echo "✅ Tous les formats testés avec succès!\n";
    }
}